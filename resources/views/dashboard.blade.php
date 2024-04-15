<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <h3 class="font-semibold text-lg">Hello to MindTheHack</h3>
                    <p>
                        This application was developed as part of a technical assessment from <strong>MindTheHack</strong> .
                        It is designed as a multi-tenant Software as a Service (SaaS) that allows multiple users to manage their respective resources utilizing the domain.
                        The primary goal was to demonstrate my ability to architect and implement scalable and secure multi-tenant systems using Laravel and Livewire.
                    </p><br>

                    <h3 class="font-semibold text-lg">Technologies Used</h3>
                    <ul class="list-disc pl-5">
                        <li><strong>Backend:</strong> Laravel 11</li>
                        <li><strong>Frontend:</strong> Livewire, Tailwind CSS for styling</li>
                        <li><strong>Database:</strong> MySQL, with tenant isolation using Spatie's Multitenancy</li>
                        <li><strong>Security:</strong> Laravel's built-in security features, Testing, Spatie's Roles & Permissions</li>
                    </ul><br>

                    <h3 class="font-semibold text-lg">Assumptions & Ideas </h3>
                    <p>Admins can create, read, update, and delete (CRUD) all entries, whereas moderators have CRUD capabilities only on entries they have created.</p>

                    <p>
                        Since it was a user facing app and not api focused I choose to substitute Controllers with Components.
                        This allowed me to have instant updates to the UI, which I thought was more important to than separation of concerns(Business Logic) with a dedicated controller.
                    </p><br>

                    <p>
                        Multitenancy works on a database per-tenant basis with a landlord database working as a catalog.
                        Inspiration about the pattern was taken from here : <br>
                        <a class="font-bold text-lg text-blue-500" href="https://medium.com/ascentic-technology/multi-tenant-saas-application-design-patterns-cost-effective-deployment-options-in-azure-and-e99b23d3156f">Multi tenancy pattern reading </a>
                    </p>

                    <div class="py-6 px-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h3 class="font-semibold text-lg text-gray-800">Basic Directions:</h3>
                        <p class="mt-2 text-gray-600">Use the following commands to set up and test the application:</p>

                        <div class="bg-gray-100 p-3 rounded">
                            <p><strong>Start the application:</strong></p>
                            <pre><code class="text-green-600">sail up -d</code></pre>
                            <button onclick="copyText('sail up -d')" class="mt-2 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                Copy
                            </button>

                            <p class="mt-4"><strong>Setup Databases:</strong></p>
                            <pre><code class="text-green-600">./setup-databases.sh</code></pre>
                            <button onclick="copyText('./setup-databases.sh')" class="mt-2 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                Copy
                            </button>

                            <p class="mt-4"><strong>Run Tests:</strong></p>
                            <pre><code class="text-green-600">sail pest</code></pre>
                            <button onclick="copyText('sail pest')" class="mt-2 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                                Copy
                            </button>
                        </div>

                        <script>
                            function copyText(text) {
                                navigator.clipboard.writeText(text);
                                alert('Command copied to clipboard');
                            }
                        </script>
                    </div>


                    <h3 class="font-semibold text-lg">Areas for Improvement</h3>
                    <ul class="list-disc pl-5">
                        <li>Search functionality</li>
                        <li>Adding modals for editing.</li>
                        <li>Ulid support</li>
                        <li>Table pagination</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
