@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h1 class="mb-0">Privacy Policy</h1>
                <small class="text-muted">Last updated: {{ now()->format('F j, Y') }}</small>
            </div>
            <div class="card-body">
                <div class="privacy-content">
                    <h3>1. Information We Collect</h3>
                    <p>We collect information you provide directly to us, such as when you create or modify your account, request customer support, or otherwise communicate with us. This information may include:</p>
                    <ul>
                        <li>Personal information like your name and email address</li>
                        <li>Account credentials (encrypted passwords)</li>
                        <li>Communication preferences</li>
                        <li>Any other information you choose to provide</li>
                    </ul>

                    <h3>2. How We Use Your Information</h3>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and send related information</li>
                        <li>Send technical notices, updates, security alerts, and support messages</li>
                        <li>Respond to your comments, questions, and customer service requests</li>
                        <li>Communicate with you about products, services, and events</li>
                        <li>Monitor and analyze trends, usage, and activities</li>
                    </ul>

                    <h3>3. Information Sharing and Disclosure</h3>
                    <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy:</p>
                    <ul>
                        <li><strong>Service Providers:</strong> We may share your information with third-party service providers who perform services on our behalf</li>
                        <li><strong>Legal Requirements:</strong> We may disclose your information if required by law or in response to valid requests by public authorities</li>
                        <li><strong>Business Transfers:</strong> We may share or transfer your information in connection with any merger, sale of assets, or acquisition</li>
                    </ul>

                    <h3>4. Data Security</h3>
                    <p>We take reasonable measures to help protect your personal information from loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction. However, no internet or email transmission is ever fully secure or error-free.</p>

                    <h3>5. Data Retention</h3>
                    <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required or permitted by law.</p>

                    <h3>6. Your Rights and Choices</h3>
                    <p>You have certain rights regarding your personal information, including:</p>
                    <ul>
                        <li><strong>Access:</strong> You can request access to your personal information</li>
                        <li><strong>Update:</strong> You can update or correct your personal information</li>
                        <li><strong>Delete:</strong> You can request deletion of your personal information</li>
                        <li><strong>Opt-out:</strong> You can opt-out of receiving promotional communications</li>
                    </ul>

                    <h3>7. Cookies and Tracking Technologies</h3>
                    <p>We use cookies and similar tracking technologies to collect and track information about your use of our service. Cookies are small data files stored on your device that help us improve our service and your experience.</p>

                    <h3>8. Children's Privacy</h3>
                    <p>Our service is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware that we have collected personal information from a child under 13, we will take steps to remove such information.</p>

                    <h3>9. International Data Transfers</h3>
                    <p>Your information may be transferred to and processed in countries other than your own. These countries may have different data protection laws than your country of residence.</p>

                    <h3>10. Changes to This Privacy Policy</h3>
                    <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "Last updated" date at the top of this policy.</p>

                    <h3>11. Contact Us</h3>
                    <p>If you have any questions about this privacy policy or our practices, please contact us at:</p>
                    <div class="contact-info bg-light p-3 rounded">
                        <p><strong>Email:</strong> privacy@laravelapp.com</p>
                        <p><strong>Address:</strong> 123 Laravel Street, Framework City, FC 12345</p>
                        <p class="mb-0"><strong>Phone:</strong> (555) 123-4567</p>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h5 class="alert-heading">Your Privacy Matters</h5>
                        <p class="mb-0">We are committed to protecting your privacy and ensuring you have a positive experience on our platform. If you have any concerns or questions about how we handle your data, please don't hesitate to reach out to us.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection