<!DOCTYPE html>
<html>
<head>
    <title>Appointment Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .details, .footer {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /* table, th, td {
            border: 1px solid black;
        } */
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Appointment Invoice</h1>
        
    </div>

    <div class="details">
        <h3>Appointment Details</h3>
        <table>
            <tr>
                <th>Patient Name</th>
                <td>{{ $appointment->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $appointment->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $appointment->phone }}</td>
            </tr>
            <tr>
                <th>Doctor</th>
                <td>{{ $appointment->doctor->name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $appointment->date }}</td>
            </tr>
            <tr>
                <th>Time Slot</th>
                <td>{{ $appointment->time_slot }}</td>
            </tr>
           
            <tr>
                <th>Payment Status</th>
                <td>{{ $appointment->payment_status }}</td>
            </tr>
            <tr>
                <th>Payment ID</th>
                <td>{{ $appointment->payment_id }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>Thank you for choosing our service!</strong></p>
    </div>
</body>
</html>
