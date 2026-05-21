<!DOCTYPE html>
<html lang="en">
<head>
    @extends('fypcoordinator.css')
    @section('title', 'User Listing')
    <style>
        <style>
        table{
            margin: 20px 0;
            border: 5px solid black;
            width: 100%;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size:18px;
            border: 1px solid black;
            font-weight: bold;
        }
        th{
            background-color: skyblue;

        }

        td{
            padding:10px;
        }
        img {
            max-width: 300px; /* Restrict image width */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
    </style>
</head>
<body>
    <h1>Quota List</h1>

    <table>
        <thead>

                <tr>
                    <th>Lecturer ID</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Number Quota</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($data as $data)
                <tr>
                        <!-- Row for Students -->
                        <td>{{ $data->lecturerID }}</td>
                        <td>{{$data->user->email}}</td>
                        <td>{{ $data->name}}</td>
                        <td>{{ $data->numberQuota}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
