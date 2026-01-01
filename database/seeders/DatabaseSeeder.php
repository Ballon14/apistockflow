<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with different roles
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@stockflow.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@stockflow.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@stockflow.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '081234567892',
            'is_active' => true,
        ]);

        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
            'slug' => 'electronics',
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'description' => 'Apparel and fashion items',
            'slug' => 'clothing',
        ]);

        $food = Category::create([
            'name' => 'Food & Beverage',
            'description' => 'Food and drink products',
            'slug' => 'food-beverage',
        ]);

        $furniture = Category::create([
            'name' => 'Furniture',
            'description' => 'Home and office furniture',
            'slug' => 'furniture',
        ]);

        // Create suppliers
        $supplier1 = Supplier::create([
            'name' => 'PT Elektronik Jaya',
            'code' => 'SUP-001',
            'email' => 'sales@elektronikjaya.com',
            'phone' => '0213456789',
            'address' => 'Jl. Sudirman No. 123',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'contact_person' => 'Budi Santoso',
            'is_active' => true,
        ]);

        $supplier2 = Supplier::create([
            'name' => 'CV Fashion Indonesia',
            'code' => 'SUP-002',
            'email' => 'order@fashionindo.com',
            'phone' => '0217654321',
            'address' => 'Jl. Gatot Subroto No. 456',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'contact_person' => 'Siti Rahayu',
            'is_active' => true,
        ]);

        $supplier3 = Supplier::create([
            'name' => 'UD Makanan Sehat',
            'code' => 'SUP-003',
            'email' => 'info@makanansehat.com',
            'phone' => '0218889999',
            'address' => 'Jl. HR Rasuna Said No. 789',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'contact_person' => 'Ahmad Hidayat',
            'is_active' => true,
        ]);

        // Create warehouses
        $warehouse1 = Warehouse::create([
            'name' => 'Warehouse Jakarta Pusat',
            'code' => 'WH-JKT-01',
            'address' => 'Jl. Thamrin No. 100',
            'city' => 'Jakarta Pusat',
            'country' => 'Indonesia',
            'manager_name' => 'Dedi Kurniawan',
            'phone' => '0212223344',
            'is_active' => true,
        ]);

        $warehouse2 = Warehouse::create([
            'name' => 'Warehouse Jakarta Utara',
            'code' => 'WH-JKT-02',
            'address' => 'Jl. Pluit No. 200',
            'city' => 'Jakarta Utara',
            'country' => 'Indonesia',
            'manager_name' => 'Rina Wijaya',
            'phone' => '0215556677',
            'is_active' => true,
        ]);

        $warehouse3 = Warehouse::create([
            'name' => 'Warehouse Bandung',
            'code' => 'WH-BDG-01',
            'address' => 'Jl. Dago No. 300',
            'city' => 'Bandung',
            'country' => 'Indonesia',
            'manager_name' => 'Eko Prasetyo',
            'phone' => '0227778899',
            'is_active' => true,
        ]);

        // Create products
        $products = [
            [
                'category_id' => $electronics->id,
                'supplier_id' => $supplier1->id,
                'sku' => 'ELEC-LAP-001',
                'name' => 'Laptop ASUS ROG',
                'description' => 'Gaming laptop with RTX 3060',
                'unit' => 'pcs',
                'min_stock' => 5,
                'max_stock' => 50,
                'purchase_price' => 15000000,
                'selling_price' => 18000000,
                'is_active' => true,
            ],
            [
                'category_id' => $electronics->id,
                'supplier_id' => $supplier1->id,
                'sku' => 'ELEC-HP-001',
                'name' => 'Smartphone Samsung Galaxy S23',
                'description' => 'Latest flagship smartphone',
                'unit' => 'pcs',
                'min_stock' => 10,
                'max_stock' => 100,
                'purchase_price' => 10000000,
                'selling_price' => 12500000,
                'is_active' => true,
            ],
            [
                'category_id' => $clothing->id,
                'supplier_id' => $supplier2->id,
                'sku' => 'CLO-TSH-001',
                'name' => 'T-Shirt Cotton Premium',
                'description' => '100% cotton comfortable t-shirt',
                'unit' => 'pcs',
                'min_stock' => 50,
                'max_stock' => 500,
                'purchase_price' => 50000,
                'selling_price' => 85000,
                'is_active' => true,
            ],
            [
                'category_id' => $clothing->id,
                'supplier_id' => $supplier2->id,
                'sku' => 'CLO-JNS-001',
                'name' => 'Jeans Denim Blue',
                'description' => 'Classic denim jeans',
                'unit' => 'pcs',
                'min_stock' => 30,
                'max_stock' => 300,
                'purchase_price' => 150000,
                'selling_price' => 250000,
                'is_active' => true,
            ],
            [
                'category_id' => $food->id,
                'supplier_id' => $supplier3->id,
                'sku' => 'FOOD-SNK-001',
                'name' => 'Potato Chips 100g',
                'description' => 'Crispy potato chips original flavor',
                'unit' => 'box',
                'min_stock' => 100,
                'max_stock' => 1000,
                'purchase_price' => 8000,
                'selling_price' => 12000,
                'is_active' => true,
            ],
            [
                'category_id' => $food->id,
                'supplier_id' => $supplier3->id,
                'sku' => 'FOOD-BEV-001',
                'name' => 'Mineral Water 600ml',
                'description' => 'Pure mineral water',
                'unit' => 'carton',
                'min_stock' => 50,
                'max_stock' => 500,
                'purchase_price' => 20000,
                'selling_price' => 30000,
                'is_active' => true,
            ],
            [
                'category_id' => $furniture->id,
                'supplier_id' => $supplier1->id,
                'sku' => 'FURN-CHR-001',
                'name' => 'Office Chair Ergonomic',
                'description' => 'Comfortable ergonomic office chair',
                'unit' => 'pcs',
                'min_stock' => 10,
                'max_stock' => 100,
                'purchase_price' => 800000,
                'selling_price' => 1200000,
                'is_active' => true,
            ],
            [
                'category_id' => $furniture->id,
                'supplier_id' => $supplier1->id,
                'sku' => 'FURN-DSK-001',
                'name' => 'Standing Desk Adjustable',
                'description' => 'Height adjustable standing desk',
                'unit' => 'pcs',
                'min_stock' => 5,
                'max_stock' => 50,
                'purchase_price' => 2000000,
                'selling_price' => 3000000,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Create initial stock for each product in each warehouse
            foreach ([$warehouse1, $warehouse2, $warehouse3] as $warehouse) {
                ProductStock::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => rand(10, 100),
                    'reserved_quantity' => 0,
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('Admin - Email: admin@stockflow.com, Password: password');
        $this->command->info('Manager - Email: manager@stockflow.com, Password: password');
        $this->command->info('Staff - Email: staff@stockflow.com, Password: password');
    }
}
