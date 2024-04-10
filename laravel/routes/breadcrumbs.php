<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Settings Index
Breadcrumbs::for('settings.index', function ($trail) {
    $trail->push('Settings', route('settings.index'));
});

// Settings Update
Breadcrumbs::for('settings.update', function ($trail, $setting) {
    $trail->parent('settings.index');
    $trail->push('Update Setting', route('settings.update', $setting));
});

// Profiles
Breadcrumbs::for('profile.show', function ($trail, $profile) {
    $trail->push('Profile', route('profile.show', $profile));
});

Breadcrumbs::for('profile.edit', function ($trail, $profile) {
    $trail->parent('profile.show', $profile);
    $trail->push('Edit Profile', route('profile.edit', $profile));
});

// Users
Breadcrumbs::for('users.index', function ($trail) {
    $trail->push('Users', route('users.index'));
});
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.index');
    $trail->push('Create User', route('users.create'));
});

Breadcrumbs::for('users.show', function ($trail, $user) {
    $trail->parent('Users');
    $trail->push($user->name, route('users.show', $user));
});

Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('Users', $user);
    $trail->push('Edit User', route('users.edit', $user));
});

// Articles
Breadcrumbs::for('articles.index', function ($trail) {
    $trail->push('Articles', route('articles.index'));
});

Breadcrumbs::for('articles.create', function ($trail) {
    $trail->parent('Articles');
    $trail->push('Create Article', route('articles.create'));
});

Breadcrumbs::for('articles.show', function ($trail, $article) {
    $trail->parent('Articles');
    $trail->push($article->title, route('articles.show', $article));
});

Breadcrumbs::for('articles.edit', function ($trail, $article) {
    $trail->parent('Articles', $article);
    $trail->push('Edit', route('articles.edit', $article));
});

// Categories
Breadcrumbs::for('categories.index', function ($trail) {
    $trail->push('Categories', route('categories.index'));
});

Breadcrumbs::for('categories.create', function ($trail) {
    $trail->parent('Categories');
    $trail->push('Create Category', route('categories.create'));
});

Breadcrumbs::for('categories.show', function ($trail, $category) {
    $trail->parent('Categories');
    $trail->push($category->name, route('categories.show', $category));
});

Breadcrumbs::for('categories.edit', function ($trail, $category) {
    $trail->parent('Categories', $category);
    $trail->push('Edit', route('categories.edit', $category));
});



