// Interactive chart editing functionality
document.addEventListener('DOMContentLoaded', function() {
    const barsArea = document.getElementById('barsArea');
    const growthChart = document.getElementById('growthChart');
    const modal = document.getElementById('editModal');
    const closeBtn = document.querySelector('.close');
    const editForm = document.getElementById('editForm');
    let currentBar = null;
    let maxRevenue = 1000000;

    // Make revenue bars editable
    if (barsArea) {
        barsArea.addEventListener('dblclick', function(e) {
            const bar = e.target.closest('.bar');
            if (bar && bar.classList.contains('bar')) {
                openEditModal(bar, 'revenue');
            }
        });

        // Add hover effect
        barsArea.addEventListener('mouseover', function(e) {
            const bar = e.target.closest('.bar');
            if (bar) {
                bar.style.cursor = 'pointer';
                bar.style.opacity = '0.8';
            }
        });

        barsArea.addEventListener('mouseout', function(e) {
            const bar = e.target.closest('.bar');
            if (bar) {
                bar.style.opacity = '0.95';
            }
        });
    }

    // Make growth rate bars editable
    if (growthChart) {
        growthChart.addEventListener('dblclick', function(e) {
            const bar = e.target.closest('.rec-bar');
            if (bar) {
                openEditModal(bar, 'growth_rate');
            }
        });

        growthChart.addEventListener('mouseover', function(e) {
            const bar = e.target.closest('.rec-bar');
            if (bar) {
                bar.style.cursor = 'pointer';
                bar.style.opacity = '0.8';
            }
        });

        growthChart.addEventListener('mouseout', function(e) {
            const bar = e.target.closest('.rec-bar');
            if (bar) {
                bar.style.opacity = '0.95';
            }
        });
    }

    function openEditModal(element, type) {
        currentBar = element;
        const period = element.getAttribute('data-period');
        
        if (type === 'revenue') {
            const value = parseFloat(element.getAttribute('data-value'));
            const dataType = element.getAttribute('data-type');
            document.getElementById('editPeriod').value = period;
            document.getElementById('editType').value = dataType;
            document.getElementById('editValue').value = value;
            document.getElementById('editLabel').textContent = dataType.replace('_', ' ').toUpperCase() + ':';
            modal.style.display = 'block';
        } else if (type === 'growth_rate') {
            const rate = parseFloat(element.getAttribute('data-rate'));
            document.getElementById('editPeriod').value = period;
            document.getElementById('editType').value = 'growth_rate';
            document.getElementById('editValue').value = rate;
            document.getElementById('editLabel').textContent = 'Growth Rate (%):';
            modal.style.display = 'block';
        }
    }

    closeBtn.onclick = function() {
        modal.style.display = 'none';
        currentBar = null;
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            currentBar = null;
        }
    }

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const period = document.getElementById('editPeriod').value;
        const type = document.getElementById('editType').value;
        const value = parseFloat(document.getElementById('editValue').value);

        if (type === 'growth_rate') {
            updateGrowthRate(period, value);
        } else {
            updateRevenue(period, type, value);
        }
    });

    function updateRevenue(period, type, value) {
        // Get all values for this period
        const barGroup = currentBar.closest('.bar-group');
        const bars = barGroup.querySelectorAll('.bar');
        const data = {
            type: 'revenue',
            period: parseInt(period),
            top_25: parseFloat(bars[0].getAttribute('data-value')),
            top_35: parseFloat(bars[1].getAttribute('data-value')),
            bottom_10: parseFloat(bars[2].getAttribute('data-value')),
            median: parseFloat(bars[3].getAttribute('data-value'))
        };

        // Update the specific value
        data[type] = value;

        // Update the bar
        fetch('api_update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Update the bar visually
                currentBar.setAttribute('data-value', value);
                const maxRevenue = getMaxRevenue();
                const height = Math.max((value / maxRevenue) * 240, 5);
                currentBar.style.height = height + 'px';
                currentBar.setAttribute('title', type.replace('_', ' ') + ': Rp ' + formatNumber(value));
                
                // Update the data attribute in the bar group
                const barGroup = currentBar.closest('.bar-group');
                const allBars = barGroup.querySelectorAll('.bar');
                allBars.forEach(bar => {
                    if (bar.getAttribute('data-type') === type) {
                        bar.setAttribute('data-value', value);
                    }
                });
                
                // Update Y-axis labels if needed
                updateYAxisLabels(maxRevenue);
                
                modal.style.display = 'none';
                currentBar = null;
                
                // Show success message
                showNotification('Data updated successfully!');
            } else {
                alert('Error updating data: ' + result.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating data');
        });
    }

    function updateGrowthRate(period, value) {
        const data = {
            type: 'growth_rate',
            period: parseInt(period),
            rate: value
        };

        fetch('api_update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Update the bar visually
                currentBar.setAttribute('data-rate', value);
                const maxGrowth = 22;
                const height = Math.max((value / maxGrowth) * 200, 5);
                currentBar.style.height = height + 'px';
                currentBar.setAttribute('title', 'Period ' + period + ': ' + value.toFixed(1) + '%');
                
                modal.style.display = 'none';
                currentBar = null;
                
                showNotification('Growth rate updated successfully!');
            } else {
                alert('Error updating data: ' + result.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating data');
        });
    }

    function getMaxRevenue() {
        const bars = document.querySelectorAll('.bar[data-value]');
        let max = 0;
        bars.forEach(bar => {
            const value = parseFloat(bar.getAttribute('data-value'));
            if (value > max) max = value;
        });
        return Math.max(max, 1000000);
    }

    function updateYAxisLabels(maxRevenue) {
        const labels = document.getElementById('yAxisLabels');
        if (labels) {
            labels.innerHTML = `
                <div>Rp ${formatNumber(maxRevenue)}</div>
                <div>Rp ${formatNumber(maxRevenue * 0.75)}</div>
                <div>Rp ${formatNumber(maxRevenue * 0.5)}</div>
                <div>Rp ${formatNumber(maxRevenue * 0.25)}</div>
                <div>Rp 0</div>
            `;
        }
    }

    function formatNumber(num) {
        return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #00cc88;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Toggle chart labels
    const showLabelsCheckbox = document.getElementById('showLabels');
    if (showLabelsCheckbox) {
        showLabelsCheckbox.addEventListener('change', function() {
            const labels = document.querySelectorAll('.period-label');
            labels.forEach(label => {
                label.style.display = this.checked ? 'block' : 'none';
            });
        });
    }

    // Overlay metrics toggle
    const overlayCheckbox = document.getElementById('overlayMetrics');
    if (overlayCheckbox) {
        overlayCheckbox.addEventListener('change', function() {
            // Add visual indicator for overlay
            const barsArea = document.getElementById('barsArea');
            if (this.checked) {
                barsArea.style.border = '1px dashed rgba(111, 243, 176, 0.3)';
            } else {
                barsArea.style.border = '1px dashed rgba(255,255,255,0.02)';
            }
        });
    }
});

