<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Listing - Item Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Item Listing</h1>
                <p class="text-sm text-slate-500 mt-1">Manage your inventory, adjust quantities, and restore items.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                Connected
            </span>
        </div>

        <!-- Feedback Alerts -->
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-lg p-4 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Done</span>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-lg p-4">
                <p class="font-medium mb-1">Please fix the following:</p>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Item Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">Add New Item</h2>
            <form action="{{ route('items.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="name" 
                        placeholder="Item name (e.g. Apples, Notebook)" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    >
                </div>
                <div class="w-full sm:w-32">
                    <input 
                        type="number" 
                        name="quantity" 
                        placeholder="Qty" 
                        min="0"
                        value="{{ old('quantity', 1) }}" 
                        required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                    >
                </div>
                <button 
                    type="submit" 
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition flex items-center justify-center gap-1.5 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Add Item
                </button>
            </form>
        </div>

        <!-- Active Items List -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Items</h2>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                    {{ count($items) }} {{ count($items) === 1 ? 'item' : 'items' }}
                </span>
            </div>

            @if (count($items) === 0)
                <div class="p-8 text-center text-slate-400 text-sm">
                    No items yet. Use the form above to add your first item.
                </div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($items as $item)
                        <li class="p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/75 transition">
                            <!-- Item Name & Details -->
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ $item->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">ID: #{{ $item->id }}</p>
                            </div>

                            <!-- Actions: Quantity & Delete -->
                            <div class="flex items-center gap-3 self-end sm:self-center">
                                <!-- Quantity Controls -->
                                <div class="inline-flex items-center rounded-lg border border-slate-300 bg-white shadow-xs">
                                    <!-- Decrement -->
                                    <form action="{{ route('items.decrement', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            title="Decrease quantity"
                                            class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-l-md font-bold text-sm transition"
                                        >
                                            −
                                        </button>
                                    </form>

                                    <!-- Current Quantity -->
                                    <span class="px-3 py-1 text-sm font-semibold text-slate-800 min-w-[2.5rem] text-center select-none">
                                        {{ $item->quantity }}
                                    </span>

                                    <!-- Increment -->
                                    <form action="{{ route('items.increment', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            title="Increase quantity"
                                            class="w-8 h-8 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-r-md font-bold text-sm transition"
                                        >
                                            +
                                        </button>
                                    </form>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('items.delete', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="px-3 py-1.5 text-xs font-medium text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-transparent hover:border-rose-200 rounded-lg transition"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Trashed Items List -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Trash</h2>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                    {{ count($trashedItems) }}
                </span>
            </div>

            @if (count($trashedItems) === 0)
                <div class="p-6 text-center text-slate-400 text-sm">
                    Trash is empty.
                </div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($trashedItems as $trashedItem)
                        <li class="p-4 sm:px-6 flex items-center justify-between gap-3 bg-slate-50/50">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-slate-500 line-through truncate">{{ $trashedItem->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Quantity: {{ $trashedItem->quantity }}</p>
                            </div>

                            <form action="{{ route('items.restore', $trashedItem->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 border border-transparent hover:border-indigo-200 rounded-lg transition"
                                >
                                    Restore
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
</body>
</html>