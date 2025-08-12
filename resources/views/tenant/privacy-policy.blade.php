@extends('tenant.layouts.app')

@section('title', 'Privacy Policy - ' . $tenant->name)

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
                    
                    <div class="prose max-w-none">
                        <p class="text-lg text-gray-600 mb-6">
                            Last updated: {{ date('F j, Y') }}
                        </p>

                        <div class="space-y-8">
                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Information We Collect</h2>
                                <p class="text-gray-700 mb-4">
                                    {{ $tenant->name }} collects information you provide directly to us, such as when you create an account, 
                                    use our services, or contact us for support.
                                </p>
                                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                                    <li>Account information (name, email address, password)</li>
                                    <li>Profile information you choose to provide</li>
                                    <li>Content you create or upload to our service</li>
                                    <li>Communications between you and {{ $tenant->name }}</li>
                                </ul>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. How We Use Your Information</h2>
                                <p class="text-gray-700 mb-4">
                                    We use the information we collect to:
                                </p>
                                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                                    <li>Provide, maintain, and improve our services</li>
                                    <li>Process transactions and send related information</li>
                                    <li>Send technical notices and support messages</li>
                                    <li>Respond to your comments and questions</li>
                                    <li>Protect against fraud and abuse</li>
                                </ul>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Information Sharing</h2>
                                <p class="text-gray-700 mb-4">
                                    {{ $tenant->name }} does not sell, trade, or otherwise transfer your personal information to third parties 
                                    without your consent, except in the following circumstances:
                                </p>
                                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                                    <li>With your explicit consent</li>
                                    <li>To comply with legal obligations</li>
                                    <li>To protect our rights and safety</li>
                                    <li>In connection with a business transfer</li>
                                </ul>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Data Security</h2>
                                <p class="text-gray-700">
                                    We implement appropriate security measures to protect your personal information against unauthorized 
                                    access, alteration, disclosure, or destruction. However, no method of transmission over the internet 
                                    or electronic storage is 100% secure.
                                </p>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Your Rights</h2>
                                <p class="text-gray-700 mb-4">
                                    You have the right to:
                                </p>
                                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                                    <li>Access and update your personal information</li>
                                    <li>Request deletion of your personal information</li>
                                    <li>Object to processing of your personal information</li>
                                    <li>Request portability of your personal information</li>
                                </ul>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Cookies</h2>
                                <p class="text-gray-700">
                                    We use cookies and similar tracking technologies to improve your experience on our service. 
                                    You can control cookies through your browser settings, but disabling cookies may affect 
                                    the functionality of our service.
                                </p>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Changes to This Policy</h2>
                                <p class="text-gray-700">
                                    We may update this privacy policy from time to time. We will notify you of any changes by 
                                    posting the new privacy policy on this page and updating the "Last updated" date.
                                </p>
                            </section>

                            <section>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Contact Us</h2>
                                <p class="text-gray-700">
                                    If you have any questions about this privacy policy or our practices, please contact us at:
                                </p>
                                <div class="bg-gray-50 p-4 rounded-lg mt-4">
                                    <p class="text-gray-700">
                                        <strong>{{ $tenant->name }}</strong><br>
                                        Email: privacy@{{ strtolower(str_replace(' ', '', $tenant->name)) }}.com<br>
                                        Subject: Privacy Policy Inquiry
                                    </p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection