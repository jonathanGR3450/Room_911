<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-2">
        <table class="table table-bordered mb-2">
            <thead>
                <tr class="table-danger">
                    <th scope="col">id</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Has Access</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees ?? '' as $data)
                    <tr>
                        <th scope="row">{{ $data->id()->value() }}</th>
                        <td>{{ $data->firstName()->value() }}</td>
                        <td>{{ $data->lastName()->value() }}</td>
                        <td>{{ $data->department()->value() }}</td>
                        <td>{{ $data->hasAccess()->value() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
