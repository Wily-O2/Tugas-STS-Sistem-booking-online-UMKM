// Data untuk bulan dan hari
const months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

let currentMonth = 8; // September (0-indexed)
let currentYear = 2025;
let selectedDay = 1;
let selectedTime = null;

// Fungsi untuk mendapatkan nama hari dari tanggal
function getDayName(day, month, year) {
    const date = new Date(year, month, day);
    return daysOfWeek[date.getDay()];
}

// Fungsi untuk mendapatkan jumlah hari dalam bulan
function getDaysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
}

// Fungsi untuk mendapatkan hari pertama dalam bulan (0 = Minggu, 1 = Senin, dst)
function getFirstDayOfMonth(month, year) {
    return new Date(year, month, 1).getDay();
}

// Fungsi untuk update tampilan bulan
function updateMonthDisplay() {
    const currentMonthDisplay = document.getElementById('currentMonth');
    currentMonthDisplay.textContent = `${months[currentMonth].substr(0, 3)} ${currentYear}`;
}

// Fungsi untuk update kalender
function updateCalendar() {
    const daysInMonth = getDaysInMonth(currentMonth, currentYear);
    const firstDay = getFirstDayOfMonth(currentMonth, currentYear);
    const daysContainer = document.querySelector('.days');
    
    // Kosongkan container
    daysContainer.innerHTML = '';
    
    // Konversi hari pertama (0=Minggu, 1=Senin) ke format Senin=0
    let startDay = firstDay === 0 ? 6 : firstDay - 1;
    
    // Tambahkan cell kosong untuk hari sebelum tanggal 1
    for (let i = 0; i < startDay; i++) {
        const emptyDiv = document.createElement('div');
        daysContainer.appendChild(emptyDiv);
    }
    
    // Tambahkan hari-hari dalam bulan
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day');
        dayDiv.textContent = day;
        dayDiv.dataset.day = day;
        
        // Set tanggal yang dipilih sebagai active
        if (day === selectedDay) {
            dayDiv.classList.add('active');
        }
        
        // Event listener untuk klik hari
        dayDiv.addEventListener('click', function() {
            selectDay(day);
        });
        
        daysContainer.appendChild(dayDiv);
    }
    
    updateMonthDisplay();
    updateBookingDate();
}

// Fungsi untuk memilih hari
function selectDay(day) {
    selectedDay = day;
    
    // Hapus class active dari semua hari
    const allDays = document.querySelectorAll('.day');
    allDays.forEach(d => d.classList.remove('active'));
    
    // Tambahkan class active ke hari yang dipilih
    const selectedDayElement = document.querySelector(`.day[data-day="${day}"]`);
    if (selectedDayElement) {
        selectedDayElement.classList.add('active');
    }
    
    updateBookingDate();
}

// Fungsi untuk update tanggal booking
function updateBookingDate() {
    const bookingDateDisplay = document.getElementById('bookingDate');
    const dayName = getDayName(selectedDay, currentMonth, currentYear);
    const monthName = months[currentMonth].substr(0, 3);
    bookingDateDisplay.textContent = `${dayName}, ${monthName} ${selectedDay}`;
}

// Fungsi untuk setup time slots
function setupTimeSlots() {
    const timeSlots = document.querySelectorAll('.time-slot:not(.confirm)');
    
    timeSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            // Hapus class selected dari semua slot
            timeSlots.forEach(s => s.classList.remove('selected'));
            
            // Tambahkan class selected ke slot yang diklik
            this.classList.add('selected');
            
            // Simpan waktu yang dipilih
            selectedTime = this.textContent;
            
            console.log('Time selected:', selectedTime);
        });
    });
}

// Fungsi untuk handle konfirmasi booking
function handleConfirm() {
    const confirmBtn = document.getElementById('confirmBtn');
    
    confirmBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const selectedTimeSlot = document.querySelector('.time-slot.selected');
        
        if (selectedTimeSlot) {
            const dayName = getDayName(selectedDay, currentMonth, currentYear);
            const monthName = months[currentMonth];
            const fullDate = `${dayName}, ${monthName} ${selectedDay}, ${currentYear}`;
            
            // Tampilkan alert konfirmasi
            alert(`✅ Booking Confirmed!\n\n📅 Date: ${fullDate}\n⏰ Time: ${selectedTime}\n\nThank you for your booking!`);
            
            // Optional: Reset pilihan setelah confirm
            // resetSelection();
            
            console.log('Booking confirmed:', {
                date: fullDate,
                time: selectedTime
            });
        } else {
            // Jika belum memilih waktu
            alert('⚠️ Please select a time slot first!');
        }
    });
}

// Fungsi untuk reset selection (optional)
function resetSelection() {
    const timeSlots = document.querySelectorAll('.time-slot:not(.confirm)');
    timeSlots.forEach(s => s.classList.remove('selected'));
    selectedTime = null;
}

// Setup navigasi bulan
function setupMonthNavigation() {
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    
    prevMonthBtn.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        selectedDay = 1;
        updateCalendar();
    });
    
    nextMonthBtn.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        selectedDay = 1;
        updateCalendar();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Calendar initialized');
    
    // Setup semua komponen
    updateCalendar();
    setupTimeSlots();
    setupMonthNavigation();
    handleConfirm();
    
    // Set default selected time (11.00am)
    const defaultTimeSlot = document.querySelector('.time-slot.selected');
    if (defaultTimeSlot) {
        selectedTime = defaultTimeSlot.textContent;
    }
    
    console.log('All event listeners attached');
});