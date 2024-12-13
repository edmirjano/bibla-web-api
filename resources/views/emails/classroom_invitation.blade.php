<!DOCTYPE html>
<html>
<head>
    <title>Classroom Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 py-10">
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">You're Invited to Join a Classroom!</h1>
        <p class="text-gray-700 mb-4">
            Hi there,
        </p>
        <p class="text-gray-700 mb-4">
            <strong>{{ $senderName }}</strong> (<a href="mailto:{{ $senderEmail }}" class="text-blue-600 underline">{{ $senderEmail }}</a>) has invited you to join the classroom <strong>{{ $classroomName }}</strong> where you can learn and collaborate together.
        </p>
        <p class="mb-6">
            <a href="{{ $registerLink }}" class="inline-block bg-blue-500 text-white font-semibold px-6 py-2 rounded hover:bg-blue-600 transition duration-200">Join the Classroom</a>
        </p>
        <p class="text-gray-500 text-sm">
            If you have any questions or need assistance, feel free to reply to this email.
        </p>
        <p class="text-gray-700 mt-6">Thanks,</p>
        <p class="text-gray-700">The Classroom Team</p>
    </div>
</div>
</body>
</html>
