<div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center py-12">
    <div class="w-full max-w-7xl sm:px-6 lg:px-12">

        <style>
            #window-container {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1.5rem;
                width: 100%;
            }

            .window-card {
                background-color: #f3f3f3;
                border: 2px solid #000;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 1.5rem;
                text-align: center;
                font-size: 1rem;
            }
        </style>

        <div class="text-center mb-8 flex justify-between items-center px-8">
            <h1 class="text-5xl font-bold text-gray-100">Queue Monitor</h1>
            <button onclick="toggleFullScreen('monitorTable')" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition duration-200">
                Full Screen
            </button>
        </div>

        <div wire:poll.2s="loadWindows" id="monitorTable" class="bg-gray-800 rounded-lg shadow-lg p-10">
            <div id="window-container">
                @foreach($windows as $window)
                    <div class="window-card">
                        <h2 class="text-2xl font-bold text-gray-700 mb-4">{{ $window['name'] }}</h2>
                        <p class="text-md text-gray-500 italic mb-4">Service: <span class="text-gray-800 font-medium">{{ $window['service'] }}</span></p>

                        <!-- Now Serving -->
                        <div class="mb-4">
                            <div class="text-md font-semibold text-gray-600 mb-2">Now Serving</div>
                            <div class="text-2xl font-bold text-blue-500">{{ $window['now_serving'] ?? 'N/A' }}</div>
                        </div>

                        <!-- Waiting in Line -->
                        <div>
                            <div class="text-md font-semibold text-gray-600 mb-2">Waiting in Line</div>
                            <ul class="list-none">
                                @forelse($window['waiting'] as $queue)
                                    <li class="py-1 px-2 bg-gray-300 rounded-lg mb-2">{{ $queue }}</li>
                                @empty
                                    <li class="py-1 px-2 bg-gray-300 rounded-lg">No tickets waiting</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // fullscreen
    function toggleFullScreen(elementId) {
        let element = document.getElementById(elementId);

        if (!document.fullscreenElement) {
            element.requestFullscreen()
                .then(() => {
                    element.classList.add('fullscreen-active');
                })
                .catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message}`);
                });
        } else {
            document.exitFullscreen().then(() => {
                element.classList.remove('fullscreen-active');
            });
        }
    }
    
    // slide
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('window-container');
        const cards = Array.from(container.querySelectorAll('.window-card'));
        const totalCards = cards.length;
        let currentIndex = 0;

        function slideNext() {
            // Calculate translateX to show the next set of windows
            const maxCardsInView = Math.floor(container.offsetWidth / 300); // Assuming each card is 300px wide
            const translateX = -(currentIndex * (100 / maxCardsInView));
            container.style.transform = `translateX(${translateX}%)`;
            container.style.transition = 'transform 0.5s ease-in-out';

            currentIndex += maxCardsInView;
            if (currentIndex >= totalCards) {
                currentIndex = 0; // Reset to the first set of cards
            }
        }

        // Set interval for sliding every 4 seconds
        setInterval(slideNext, 4000);
    });

    // document.addEventListener('livewire:load', function () {
    //     Livewire.on('windows-updated', function (data) {
    //         console.log('Windows updated:', data.windows);
    //         updateMonitorTable(data.windows); // Custom function to update the UI
    //     });

    //     // Function to update the monitorTable dynamically
    //     function updateMonitorTable(windows) {
    //         const container = document.getElementById('window-container');
    //         container.innerHTML = ''; // Clear the container

    //         windows.forEach(window => {
    //             const windowCard = document.createElement('div');
    //             windowCard.className = 'window-card';
    //             windowCard.innerHTML = `
    //                 <h2 class="text-2xl font-bold text-gray-700 mb-4">${window.name}</h2>
    //                 <p class="text-md text-gray-500 italic mb-4">Service: <span class="text-gray-800 font-medium">${window.service}</span></p>
    //                 <div class="mb-4">
    //                     <div class="text-md font-semibold text-gray-600 mb-2">Now Serving</div>
    //                     <div class="text-2xl font-bold text-blue-500">${window.now_serving || 'N/A'}</div>
    //                 </div>
    //                 <div>
    //                     <div class="text-md font-semibold text-gray-600 mb-2">Waiting in Line</div>
    //                     <ul class="list-none">
    //                         ${window.waiting.length ? window.waiting.map(queue => `<li class="py-1 px-2 bg-gray-300 rounded-lg mb-2">${queue}</li>`).join('') : '<li class="py-1 px-2 bg-gray-300 rounded-lg">No tickets waiting</li>'}
    //                     </ul>
    //                 </div>
    //             `;
    //             container.appendChild(windowCard);
    //         });
    //     }
    // });
</script>
