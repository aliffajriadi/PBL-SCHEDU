<div id="calendar" class="rounded-lg overflow-hidden bg-white w-full animate-fadeIn"></div>

<!-- Event Modal -->
<div id="eventModal" class="hidden fixed inset-0 bg-gray-500/50 backdrop-blur-sm flex items-center justify-center z-50">
  <div class="bg-white rounded-xl p-4 sm:p-6 max-w-md w-full mx-4 shadow-xl animate-modalIn opacity-0">
    <div class="flex justify-between items-center mb-4">
      <h2 id="eventTitle" class="text-lg sm:text-xl font-bold text-emerald-600"></h2>
      <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="mb-2 sm:mb-3 animate-slideIn opacity-0" style="animation-delay: 0.1s;">
      <p id="eventDate" class="text-sm sm:text-base text-gray-600"></p>
    </div>
    <div id="eventTimeContainer" class="mb-2 sm:mb-3 animate-slideIn opacity-0" style="animation-delay: 0.2s;">
      <p id="eventTime" class="text-sm sm:text-base text-gray-600"></p>
    </div>
    <div class="mb-2 sm:mb-3 animate-slideIn opacity-0" style="animation-delay: 0.3s;">
      <p id="eventDescription" class="text-sm sm:text-base text-gray-700"></p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var events = [
      {
        title: "Project Meeting",
        start: "2025-03-19",
        end: "2025-03-22",
        description: "Team project meeting."
      },
      {
        title: "Assignment Deadline",
        start: "2025-03-25",
        description: "Final assignment submission deadline."
      },
      {
        title: "Presentation",
        start: "2025-03-28T10:00:00",
        end: "2025-03-28T12:00:00",
        description: "Class presentation."
      }
    ];

    // Function to adapt calendar height based on window size
    function getCalendarHeight() {
      if (window.innerWidth < 640) { // Small mobile
        return 350;
      } else if (window.innerWidth < 768) { // Larger mobile
        return 400; 
      } else {
        return 450; // Tablet and desktop
      }
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: getCalendarHeight(),
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: '' // Removed the month button
      },
      buttonText: {
        today: 'Today',
      },
      events: events,
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: true
      },
      // Custom styling for buttons
      buttonIcons: {
        prev: 'chevron-left',
        next: 'chevron-right'
      },
      // Custom CSS classes for the calendar
      themeSystem: 'standard',
      bootstrapFontAwesome: false,
      // Style for the header buttons
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      eventClick: function(info) {
        // Show modal when an event is clicked
        document.getElementById('eventTitle').textContent = info.event.title;

        const startDate = info.event.start.toLocaleDateString('en-US', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });

        let dateText = startDate;

        if (info.event.end) {
          const endDate = info.event.end.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          });
          dateText += ' - ' + endDate;
        }

        document.getElementById('eventDate').textContent = dateText;

        if (info.event.start.toTimeString().substring(0, 5) !== "00:00") {
          const timeStart = info.event.start.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
          });

          let timeText = timeStart;

          if (info.event.end && info.event.end.toTimeString().substring(0, 5) !== "00:00") {
            const timeEnd = info.event.end.toLocaleTimeString('en-US', {
              hour: '2-digit',
              minute: '2-digit'
            });
            timeText += ' - ' + timeEnd;
          }

          document.getElementById('eventTime').textContent = timeText;
          document.getElementById('eventTimeContainer').classList.remove('hidden');
        } else {
          document.getElementById('eventTimeContainer').classList.add('hidden');
        }

        document.getElementById('eventDescription').textContent = info.event.extendedProps.description;
        
        // Show modal with animation
        const modal = document.getElementById('eventModal');
        const modalContent = modal.querySelector('div');
        
        // Reset animations
        const animatedElements = modal.querySelectorAll('.animate-slideIn');
        animatedElements.forEach(el => {
          el.style.opacity = '0';
        });
        
        modalContent.classList.add('opacity-0');
        modal.classList.remove('hidden');
        
        // Trigger animations
        setTimeout(() => {
          modalContent.classList.remove('opacity-0');
          
          // Animate content elements with delay
          animatedElements.forEach((el, index) => {
            setTimeout(() => {
              el.style.opacity = '1';
            }, 100 * (index + 1));
          });
        }, 10);
      },
      // Use emerald-400 and yellow colors for the calendar
      eventColor: '#34d399', // emerald-400
      eventBorderColor: '#10b981', // emerald-500
      eventTextColor: 'white',
      dayMaxEvents: true, // Show '+more' if there are too many events
      // Rounded styling for calendar elements
      dayCellClassNames: 'rounded-md mx-1 my-1 hover:bg-emerald-50 transition-colors duration-200',
      eventClassNames: 'rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200',
      // Add yellow accent for today
      dayCellDidMount: function(info) {
        if (info.isToday) {
          info.el.style.backgroundColor = '#fef3c7'; // Light yellow background for today
          info.el.style.borderRadius = '0.375rem'; // rounded-md
        }
      }
    });

    calendar.render();

    // Add custom styling for buttons after render
    const buttons = document.querySelectorAll('.fc-button');
    buttons.forEach(button => {
      button.classList.add('bg-emerald-500', 'hover:bg-emerald-600', 'text-white', 'border-emerald-600', 'rounded-md', 'transition-all', 'duration-200', 'transform', 'hover:scale-105');
      button.classList.remove('fc-button-primary');
    });

    // Animate calendar view changes
    const viewChangeButtons = document.querySelectorAll('.fc-prev-button, .fc-next-button');
    viewChangeButtons.forEach(button => {
      button.addEventListener('click', function() {
        const viewContainer = document.querySelector('.fc-view-harness');
        viewContainer.classList.add('animate-viewChange');
        setTimeout(() => {
          viewContainer.classList.remove('animate-viewChange');
        }, 300);
      });
    });

    // Close modal with animation
    document.getElementById('closeModal').addEventListener('click', function() {
      const modal = document.getElementById('eventModal');
      const modalContent = modal.querySelector('div');
      
      modalContent.classList.add('opacity-0');
      
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 300);
    });

    // Close modal when clicking outside the modal
    window.addEventListener('click', function(event) {
      if (event.target === document.getElementById('eventModal')) {
        const modal = document.getElementById('eventModal');
        const modalContent = modal.querySelector('div');
        
        modalContent.classList.add('opacity-0');
        
        setTimeout(() => {
          modal.classList.add('hidden');
        }, 300);
      }
    });

    // Resize handling for responsiveness
    window.addEventListener('resize', function() {
      calendar.setOption('height', getCalendarHeight());
    });
  });
</script>

<style>
  /* Animation keyframes */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes slideIn {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }
  
  @keyframes modalIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  
  @keyframes viewChange {
    0% { opacity: 1; }
    50% { opacity: 0.5; transform: translateX(5px); }
    100% { opacity: 1; transform: translateX(0); }
  }
  
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
  
  /* Animation classes */
  .animate-fadeIn {
    animation: fadeIn 0.5s ease-out forwards;
  }
  
  .animate-slideIn {
    animation: slideIn 0.4s ease-out forwards;
  }
  
  .animate-modalIn {
    animation: modalIn 0.3s ease-out forwards;
  }
  
  .animate-viewChange {
    animation: viewChange 0.3s ease-in-out;
  }
  
  .animate-pulse {
    animation: pulse 1.5s infinite;
  }
  
  /* Additional styling for FullCalendar buttons */
  .fc .fc-button-primary {
    background-color: #10b981 !important; /* emerald-500 - changed to deeper green */
    border-color: #059669 !important; /* emerald-600 */
    color: white !important;
    border-radius: 0.375rem !important; /* rounded-md */
    padding: 0.25rem 0.5rem !important;
    font-size: 0.875rem !important;
    transition: all 0.2s ease-in-out !important;
  }
  
  .fc .fc-button-primary:hover {
    background-color: #059669 !important; /* emerald-600 */
    transform: scale(1.05) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
  }
  
  .fc .fc-button-primary:not(:disabled).fc-button-active, 
  .fc .fc-button-primary:not(:disabled):active {
    background-color: #047857 !important; /* emerald-700 */
    border-color: #065f46 !important; /* emerald-800 */
  }
  
  /* Today button specific styling */
  .fc .fc-today-button {
    background-color: #34d399 !important; /* emerald-400 */
    border-color: #10b981 !important; /* emerald-500 */
  }
  
  /* Paginate buttons (prev/next) styling */
  .fc .fc-prev-button, .fc .fc-next-button {
    background-color: #10b981 !important; /* emerald-500 */
    border-color: #059669 !important; /* emerald-600 */
    transition: all 0.2s ease !important;
  }
  
  .fc .fc-prev-button:hover, .fc .fc-next-button:hover {
    background-color: #059669 !important; /* emerald-600 */
    transform: scale(1.1) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
  }
  
  /* Title styling - SMALLER MONTH NAME */
  .fc .fc-toolbar-title {
    color: #10b981 !important; /* emerald-500 */
    font-weight: bold;
    font-size: 1rem !important; /* Smaller size for month name */
    transition: all 0.3s ease;
  }
  
  /* Event styling with hover effects */
  .fc-event {
    transition: all 0.2s ease-in-out !important;
    cursor: pointer !important;
  }
  
  .fc-event:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
  }
  
  /* Day cell hover effect */
  .fc-daygrid-day:hover {
    background-color: rgba(16, 185, 129, 0.05) !important; /* Very light emerald */
  }
  
  /* Responsive styles */
  @media (max-width: 640px) {
    .fc .fc-toolbar-title {
      font-size: 0.875rem !important; /* Even smaller on mobile */
    }
    
    .fc .fc-col-header-cell-cushion,
    .fc .fc-daygrid-day-number {
      font-size: 0.75rem !important;
    }
    
    .fc .fc-button {
      padding: 0.15rem 0.35rem !important;
      font-size: 0.75rem !important;
    }
    
    .fc-event .fc-event-title {
      font-size: 0.7rem !important;
    }
  }
  
  /* Make sure the calendar takes full width of its container */
  #calendar {
    width: 100% !important;
  }
  
  /* Ensure day cells are properly sized on smaller screens */
  .fc-daygrid-day-frame {
    min-height: 2rem !important;
  }
  
  /* Add transition to all elements for smoother animations */
  .fc * {
    transition: background-color 0.2s, transform 0.2s, box-shadow 0.2s;
  }
</style>