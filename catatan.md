Berikut versi **sebagai catatan langkah-langkah** proyek API Laravel-mu dalam file `catatan.md`. Format ini cocok untuk ditampilkan di GitHub(maaf cuman masih setengah):

---

````markdown
# 📘 Catatan Proyek API Laravel - PEMWEB2

> **URL Proyek:** https://pemweb2.test/  
> **Disusun oleh:** Alfin

---

## ✅ LANGKAH-LANGKAH

### 1. Inisialisasi Proyek

```bash
➜ pemweb2 git:(main) dcm Product
➜ pemweb2 git:(main) ✗ dcm Client
````

---

### 2. Buat Migration

#### 🔹 Products

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
```

#### 🔹 Clients

```php
Schema::create('clients', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

---

### 3. Buat Seeder

#### 🔹 ProductSeeder

```php
Product::firstOrCreate([
    'name' => 'Default Product',
    'price' => 1.00,
]);
```

#### 🔹 ClientSeeder

```php
Client::firstOrCreate([
    'name' => 'Default Client',
]);
```

---

### 4. Buat Model

#### 🔹 Product

```php
protected $fillable = ['name', 'price'];
```

#### 🔹 Client

```php
protected $fillable = ['name'];
```

---

### 5. Buat Controller

#### 🔹 ClientController.php

```php
public function index()
{
    $data = Client::all();
    return response()->json([
        'message' => 'List of Clients',
        'data' => $data
    ], 200);
}
```

---

### 6. Atur Routing (`routes/api.php`)

```php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product');
});

Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('client');
});
```

---

### 7. Tes API

#### 🔹 Via Browser

```
https://pemweb2.test/api/clients
```

#### 🔹 Via Postman

* Method: GET
* URL: [https://pemweb2.test/api/clients](https://pemweb2.test/api/clients)
* Headers: `Content-Type: application/json`

#### 🔹 Via REST Client (VSCode)

**Langkah:**

1. Install extension **REST Client** di VSCode
2. Buat folder khusus (di luar `src`)
3. Buat file `clients.http`

```http
@baseUrl = https://pemweb2.test/api/clients
@cType = application/json

### Get all clients
GET {{baseUrl}}/
Content-Type: {{cType}}

### Get all products
GET https://pemweb2.test/api/products
Content-Type: {{cType}}
```

---

## 📌 STATUS PROYEK

* [x] Migration ✅
* [x] Seeder ✅
* [x] Model ✅
* [x] Controller ✅
* [x] Routing ✅
* [x] Tes API (Chrome, Postman, REST Client) ✅

---
