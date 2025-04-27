@extends('app')
@section('title', 'Currus-connect.com: ' . __('page-titles.home'))
@section('content')

    <div class="cta">
        <div class="d-flex justify-content-center text-center mx-auto pt-4">
            <img src="{{ asset($logoPath) }}" style="max-width: 25rem; max-height: 40rem;" class="pt-2"
                alt="{{ __('alt-tags.homepage_logo_2') }}" title="{{ $logo['title'] ?? 'Currus Connect' }}">
        </div>
        <livewire:search-forms />
    </div>

    <x-brands.car-brands-slider :brands="$brands" />

    <x-categories.part-categories :mainCategories="$mainCategories" />

    <x-blogs-homepage.recent-blogs :recentBlogs="$recentBlogs" />

@endsection


<style>
    #brand-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
        max-width: calc(7 * 12rem);
        /* Adjust width for 7 items per row */
    }

    .brand-item {
        width: 11rem;
        /* Ensure consistent size */
        height: auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
