<div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center py-12">
    <div class="w-full max-w-7xl sm:px-6 lg:px-12">

        <!-- Styles for Overflow Behavior -->
        <style>
            #monitorTable {
                overflow-y: hidden; /* Hide vertical overflow when not fullscreen */
                display: flex; /* Flexbox for vertical centering */
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: auto; /* Default height */
                min-height: 90vh; /* Ensure it's at least 90% of the screen height */
            }

            #monitorTable.fullscreen-active {
                overflow-y: auto; /* Allow scrolling in fullscreen mode */
                height: 100vh; /* Full height in fullscreen */
            }

            #window-container {
                padding: 0; /* Default padding */
            }

            #monitorTable.fullscreen-active #window-container {
                padding: 0 5%; /* Add margin to sides in fullscreen mode */
            }
        </style>

        <div class="text-center mb-8 flex justify-between items-center px-8">
            <h1 class="text-5xl font-bold text-gray-100">Queue Monitor</h1>

            <!-- Full Screen Button -->
            <button onclick="toggleFullScreen('monitorTable')" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
                Full Screen
            </button>
        </div>

        <!-- Cards Container -->
        <div id="monitorTable" class="bg-gray-800 rounded-lg shadow-lg p-10 overflow-hidden">
            <div id="window-container" class="flex items-center justify-start gap-6 transition-transform duration-700 ease-in-out">
                @foreach($windows as $index => $window)
                    <div class="window-card bg-gray-200 rounded-lg shadow-lg p-10 text-gray-800 transition-transform duration-500 ease-in-out transform hover:scale-105 flex-shrink-0" style="width: 40%; max-height: 90vh;" data-index="{{ $index }}">
                        <h2 class="text-4xl font-bold text-gray-700 mb-6 text-center">{{ $window['name'] }}</h2>
                        <p class="text-xl text-gray-500 mb-8 italic text-center">Service: <span class="text-gray-800 font-medium">{{ $window['service'] ?? 'N/A' }}</span></p>

                        <!-- Now Serving -->
                        <div class="mb-8 text-center">
                            <div class="text-xl font-semibold text-gray-600 mb-2">Now Serving</div>
                            <div class="text-4xl font-bold text-blue-500">{{ $window['now_serving'] ?? 'N/A' }}</div>
                        </div>

                        <!-- Waiting in Line -->
                        <div class="text-center">
                            <div class="text-xl font-semibold text-gray-600 mb-2">Waiting in Line</div>
                            <ul class="list-none text-2xl">
                                @forelse($window['waiting'] as $queue)
                                    <li class="py-2 px-4 bg-gray-300 rounded-lg mb-3">{{ $queue }}</li>
                                @empty
                                    <li class="py-2 px-4 bg-gray-300 rounded-lg">No tickets waiting</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Full Screen JavaScript -->
<script>
    function toggleFullScreen(elementId) {
        let element = document.getElementById(elementId);

        if (!document.fullscreenElement) {
            element.requestFullscreen()
                .then(() => {
                    element.classList.add('fullscreen-active'); // Add class to track fullscreen state
                })
                .catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message}`);
                });
        } else {
            document.exitFullscreen().then(() => {
                element.classList.remove('fullscreen-active'); // Remove class when exiting fullscreen
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('window-container');
        const cards = Array.from(container.querySelectorAll('.window-card'));
        const totalWindows = cards.length;
        const cardWidth = 35; // Adjust this to match the width percentage of each card
        let currentIndex = 0;

        function updateVisibleWindows() {
            // Calculate translateX to ensure the first card is fully visible
            const translateX = -(currentIndex * cardWidth);
            container.style.transform = `translateX(${translateX}%)`;

            currentIndex += 2;

            // Reset index if it exceeds the total windows
            if (currentIndex >= totalWindows) {
                currentIndex = 0;
            }
        }

        // Initialize with the first set of windows
        updateVisibleWindows();

        // Set interval for cycling windows every 4 seconds with smooth animation
        setInterval(updateVisibleWindows, 4000);
    });
</script>
