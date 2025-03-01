@extends('app')
@section('title', 'Part Types Categories')

@section('content')
<div class="container">
    <div class="col-12 pt-4 text-white">
        <h5>Select view</h5>
        <div class="d-flex gap-2 pt-2 pb-2">
            <button class="btn btn-primary" id="show-main-categories">Show Main Categories</button>
            <button class="btn btn-secondary" id="show-sub-categories">Show Sub Categories</button>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">Categories</div>
            <div class="card-body" id="categories-display">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        const categoriesDisplay = document.getElementById('categories-display');

        // Pass main category and part type translations from the server-side
        const mainCategories = @json($mainCategories ?? []);
        const partTypes = @json($partTypes ?? []);
        const translations = {
            mainCategories: @json($mainCategories->pluck('id')->mapWithKeys(function ($id) use ($mainCategories) {
    $category = $mainCategories->firstWhere('id', $id);
    return [$id => __("main-categories.{$category->translation_key}")];
})->toArray()),
            partTypes: @json($partTypes->pluck('id')->mapWithKeys(function ($id) use ($partTypes) {
    $type = $partTypes->firstWhere('id', $id);
    return [$id => __("car-part-types.{$type->translation_key}")];
})->toArray()),
        };

        const renderCategories = (categories, type) => {
            if (!categories.length) {
                categoriesDisplay.innerHTML = `<p>No ${type} available.</p>`;
                return;
            }

            const table = `
                <table class="table">
                    <thead>
                        <tr>
                            <th># ID</th>
                            <th>${type} Name</th>
                            ${type === 'Main Category' ? '<th>Actions</th>' : ''}
                        </tr>
                    </thead>
                    <tbody>
                        ${categories.map(category => `
                            <tr>
                                <td>${category.id}</td>
                                <td>${type === 'Main Category'
                    ? translations.mainCategories[category.id]
                    : translations.partTypes[category.id]
                }</td>
                                ${type === 'Main Category'
                    ? `<td>
                                            <a href="/admin/part-types-categories/${category.id}" class="btn btn-primary btn-sm">View</a>
                                        </td>`
                    : ''
                }
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            categoriesDisplay.innerHTML = table;
        };

        renderCategories(mainCategories, 'Main Category');

        document.getElementById('show-main-categories').addEventListener('click', () => {
            renderCategories(mainCategories, 'Main Category');
        });

        document.getElementById('show-sub-categories').addEventListener('click', () => {
            renderCategories(partTypes, 'Car Part Type');
        });
    });
</script>
@endsection