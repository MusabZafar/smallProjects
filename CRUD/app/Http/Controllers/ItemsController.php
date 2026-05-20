<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;

/**
 * ItemsController handles all incoming HTTP requests for the Car Rental Fleet Lister.
 * It coordinates database actions using Eloquent Models and returns responsive Blade views.
 */
class ItemsController extends Controller
{
    /**
     * Display a paginated listing of all vehicles in the fleet.
     * 
     * [SOLVING N+1 QUERY PROBLEM WITH EAGER LOADING]:
     * We invoke `Item::with('categoryRel')` to tell Eloquent to load category records 
     * upfront using a single SQL 'IN' query. This ensures that instead of running 
     * 1 query for items + 5 separate queries for each item's category (N+1 problem),
     * we only execute 2 queries in total (1 for items, 1 for categories).
     */
    public function index(): View
    {
        // Fetch paginated vehicles (5 per page) while eager loading their category relationships.
        $items = Item::with('categoryRel')->paginate(5);

        // Render index.blade.php view passing paginated collection & row counter offset ('i').
        return view('items.index', compact('items'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new vehicle record.
     */
    public function create(): View
    {
        // Returns the creation form view (resources/views/items/create.blade.php).
        return view('items.create');
    }

    /**
     * Store a newly created vehicle record in the SQLite database.
     * 
     * [VALIDATION HANDLED BY FORM REQUEST]:
     * The incoming payload is automatically checked by the rules defined in `ItemStoreRequest`.
     * If validation fails, Laravel redirects back with session errors and old values automatically.
     */
    public function store(ItemStoreRequest $request): RedirectResponse
    {
        // Retrieve sanitized, validated inputs from the form request.
        $validated = $request->validated();

        // Dynamically find or create the category in the database by its textual name input.
        $category = Category::firstOrCreate([
            'name' => $validated['category'],
        ]);

        // Map the autoincremented Category ID to the vehicle's foreign key field.
        $validated['category_id'] = $category->id;

        // Perform mass assignment to persist the new vehicle in the database.
        Item::create($validated);

        // Redirect user back to index table along with a green success status banner.
        return redirect()->route('items.index')
            ->with('success', 'Vehicle added successfully.');
    }

    /**
     * Display specifications for a single selected vehicle.
     * 
     * [IMPLICIT ROUTE MODEL BINDING]:
     * Laravel automatically queries the SQLite database matching the URL id and injects the `Item` instance.
     */
    public function show(Item $item): View
    {
        // Load categoryRel relation on the single model instance to prevent lazy queries in the view.
        $item->load('categoryRel');

        // Render resources/views/items/show.blade.php passing model variable.
        return view('items.show', compact('item'));
    }

    /**
     * Show the edit form loaded with existing attributes.
     */
    public function edit(Item $item): View
    {
        // Lazy eager load relationship to output current category text in form.
        $item->load('categoryRel');

        // Render resources/views/items/edit.blade.php passing model variables.
        return view('items.edit', compact('item'));
    }

    /**
     * Update specified vehicle parameters in database.
     * 
     * [FORM REQUEST VALIDATION]:
     * Validation rules are executed in `ItemUpdateRequest` to maintain code isolation.
     */
    public function update(ItemUpdateRequest $request, Item $item): RedirectResponse
    {
        // Extract validated inputs.
        $validated = $request->validated();

        // Locate or instantiate corresponding category from input name.
        $category = Category::firstOrCreate([
            'name' => $validated['category'],
        ]);

        // Link category primary key index.
        $validated['category_id'] = $category->id;

        // Persist updates to the model attributes.
        $item->update($validated);

        // Return user to fleet home.
        return redirect()->route('items.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle record from the database.
     */
    public function destroy(Item $item): RedirectResponse
    {
        // Delete the model record from the items table.
        $item->delete();

        // Redirect with confirmation notice.
        return redirect()->route('items.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    /**
     * Filter list views to show only low stock vehicles.
     * 
     * [COMPACT ORDERED FILTERING]:
     * Displays vehicles with quantity less than the specified threshold.
     * Reuses index.blade.php template ensuring no code duplication.
     */
    public function lowStock(int $threshold): View
    {
        // Query items while eager loading category relations to solve N+1,
        // filtering by quantity threshold, sorting by stock quantity, then alphabetically by name.
        $items = Item::with('categoryRel')
            ->where('quantity', '<', $threshold)
            ->orderBy('quantity')
            ->orderBy('product')
            ->paginate(5);

        // Render home dashboard displaying only low stock items.
        return view('items.index', compact('items'))
            ->with('success', "Showing vehicles with quantity less than {$threshold}");
    }
}
