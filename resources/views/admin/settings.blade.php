@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Website Settings</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your website's global settings and information</p>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Settings Form -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">General Settings</h2>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Phone Number -->
                <div class="mb-6">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Phone Number
                    </label>
                    <input type="text" id="phone_number" name="phone_number" 
                           value="{{ old('phone_number', $settings->phone_number ?? '') }}"
                           placeholder="+1-800-555-0123"
                           class="w-full px-4 py-2 border {{ $errors->has('phone_number') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Customer support phone number</p>
                </div>

                <!-- Admin Email -->
                <div class="mb-6">
                    <label for="admin_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Support Email
                    </label>
                    <input type="email" id="admin_email" name="admin_email" 
                           value="{{ old('admin_email', $settings->admin_email ?? '') }}"
                           placeholder="support@example.com"
                           class="w-full px-4 py-2 border {{ $errors->has('admin_email') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    @error('admin_email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email address for customer inquiries</p>
                </div>

                <!-- Location -->
                <div class="mb-6" x-data="locationPicker()">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Business Location
                    </label>
                    
                    <div class="mb-3">
                        <div id="map" class="h-64 rounded-lg border border-gray-300 dark:border-gray-600 mb-2"></div>
                        <button @click="getCurrentLocation()" type="button"
                                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Use my current location
                        </button>
                    </div>
                    
                    <input type="hidden" id="latitude" name="latitude" x-model="latitude">
                    <input type="hidden" id="longitude" name="longitude" x-model="longitude">
                    
                    <textarea id="location" name="location" rows="3" x-model="address"
                              placeholder="123 Main Street, City, State 12345, Country"
                              class="w-full px-4 py-2 border {{ $errors->has('location') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">{{ old('location', $settings->location ?? '') }}</textarea>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Click on the map to select your business location</p>
                </div>

                <!-- About Us -->
                <div class="mb-6">
                    <label for="about_us" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="inline h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About Us
                    </label>
                    <textarea id="about_us" name="about_us" rows="6"
                              placeholder="Tell customers about your business..."
                              class="w-full px-4 py-2 border {{ $errors->has('about_us') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">{{ old('about_us', $settings->about_us ?? '') }}</textarea>
                    @error('about_us')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Brief description of your business (displayed in footer)</p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview & Info Sidebar -->
    <div class="space-y-6">
        <!-- Current Settings Preview -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Current Settings</h2>
            
            @if($settings)
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">PHONE</p>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ $settings->phone_number ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">EMAIL</p>
                        <p class="text-sm text-gray-900 dark:text-white break-all">
                            {{ $settings->admin_email ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">LOCATION</p>
                        <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">
                            {{ $settings->location ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ABOUT</p>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ Str::limit($settings->about_us ?? 'Not set', 150) }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No settings configured yet</p>
            @endif
        </div>

        <!-- Quick Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="text-sm text-blue-800 dark:text-blue-300">
                    <p class="font-semibold mb-2">About Settings</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Displayed in website footer</li>
                        <li>Used for customer communication</li>
                        <li>Updates reflect immediately</li>
                        <li>Visible to all users</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Last Updated -->
        @if($settings && $settings->updated_at)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Last Updated</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $settings->updated_at->format('M d, Y') }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $settings->updated_at->diffForHumans() }}
                </p>
            </div>
        @endif

        <!-- Additional Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('home') }}" target="_blank"
                   class="block w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg transition duration-200 text-center">
                    View Website
                </a>
                <a href="{{ route('faq.index') }}" target="_blank"
                   class="block w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg transition duration-200 text-center">
                    Manage FAQs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('locationPicker', () => ({
        latitude: {{ $settings->latitude ?? 27.7172 }},
        longitude: {{ $settings->longitude ?? 85.3240 }},
        address: '',
        map: null,
        marker: null,
        
        init() {
            setTimeout(() => {
                this.initMap();
            }, 100);
        },
        
        initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet not loaded');
                return;
            }
            
            this.map = L.map('map').setView([this.latitude, this.longitude], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);
            
            this.marker = L.marker([this.latitude, this.longitude], {
                draggable: true
            }).addTo(this.map);
            
            this.map.on('click', (e) => {
                this.updateLocation(e.latlng.lat, e.latlng.lng);
            });
            
            this.marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this.updateLocation(pos.lat, pos.lng);
            });
        },
        
        updateLocation(lat, lng) {
            this.latitude = lat.toFixed(6);
            this.longitude = lng.toFixed(6);
            this.marker.setLatLng([lat, lng]);
            this.getAddress(lat, lng);
        },
        
        async getAddress(lat, lng) {
            try {
                const response = await fetch(\`https://nominatim.openstreetmap.org/reverse?format=json&lat=\${lat}&lon=\${lng}\`);
                const data = await response.json();
                if (data.display_name) {
                    this.address = data.display_name;
                }
            } catch (error) {
                console.error('Error fetching address:', error);
            }
        },
        
        getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    this.map.setView([lat, lng], 15);
                    this.updateLocation(lat, lng);
                }, (error) => {
                    alert('Unable to get your location: ' + error.message);
                });
            } else {
                alert('Geolocation is not supported by your browser');
            }
        }
    }));
});
</script>
@endpush
