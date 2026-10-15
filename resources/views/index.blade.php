<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8">
    <h1 class="text-3xl font-bold mb-8">Item Listing Application</h1>

    <h2 class="text-2xl font-bold mb-4">Add Item</h2>
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Item Name">
        <input type="number" name="quantity" placeholder="Quantity">
        <button type="submit">Add Item</button>
    </form>

    <h2>Items</h2>
    <ul>
        @foreach ($items as $item)x
            <li>{{ $item->name }} - {{ $item->quantity }}</li>
        @endforeach
    </ul>

    <h2>Trashed Items</h2>
    <ul>
        @foreach ($trashedItems as $trashedItem)
            <li>{{ $trashedItem->name }} - {{ $trashedItem->quantity }}</li>
        @endforeach
    </ul>
</body>
</html>