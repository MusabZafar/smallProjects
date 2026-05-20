<!DOCTYPE html>
<html>
<head>
    <title>Steam Games API UI</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; padding: 30px; }
        .container { max-width: 1000px; margin: auto; }
        h1 { text-align: center; }
        .game {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #ccc;
        }
        .genres span {
            background: #222;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            font-size: 13px;
        }
        .btn {
            padding: 8px 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .danger { background: #dc2626; }
    </style>
</head>
<body>
<div class="container">
    <h1>Steam Games List</h1>

    @foreach($games as $game)
        <div class="game">
            <h2>{{ $game->title }}</h2>
            <p>{{ $game->description }}</p>

            <div class="genres">
                @foreach($game->genres as $genre)
                    <span>{{ $genre->name }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
</body>
</html>