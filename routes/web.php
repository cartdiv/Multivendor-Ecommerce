<?php

use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\brandController;
use App\Http\Controllers\Admin\categoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\productController;
use App\Http\Controllers\Admin\ShippingAreaController;
use App\Http\Controllers\Admin\sliderController;
use App\Http\Controllers\Admin\subcategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\frontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Vendor\vendorController;
use App\Http\Controllers\Vendor\VendorProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\Compare;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth', 'roles:admin'])->group(function(){
    
    Route::controller(adminController::class)->group(function(){
        Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
        Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
        Route::get('/admin/profile', 'AdminProfile')->name('admin.profile');
        Route::post('/update/admin', 'UpdateAdmin')->name('update.admin');
        Route::get('/change/admin/password', 'ChangeAdminPassword')->name('change.admin.password');
        Route::post('/store/admin/password', 'StoreAdminPassword')->name('store.admin.password');
        
    });
   
    //Brand routing
    Route::controller(brandController::class)->group(function(){
        Route::get('/all/brand', 'AllBrand')->name('all.brand');
        Route::get('/add/brand', 'AddBrand')->name('add.brand');
        Route::post('/store/brand', 'StoreBrand')->name('store.brand');
        Route::post('/update/brand', 'UpdateBrand')->name('update.brand');
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand');

    });

     //Category routing
     Route::controller(categoryController::class)->group(function(){
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('store.category');
        Route::post('/update/category', 'UpdateCategory')->name('update.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

    });

     //Sub-Category routing
     Route::controller(subcategoryController::class)->group(function(){
        Route::get('/all/subcategory', 'AllSubcategory')->name('all.subcategory');
        Route::get('/add/subcategory', 'AddSubcategory')->name('add.subcategory');
        Route::post('/store/subcategory', 'StoreSubcategory')->name('store.subcategory');
        Route::post('/update/subcategory', 'UpdateSubcategory')->name('update.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubcategory')->name('edit.subcategory');
        Route::get('/delete/subcategory/{id}', 'DeleteSubcategory')->name('delete.subcategory');
        Route::get('/subcategory/ajax/{category_id}' , 'GetSubCategory');

    });

    //INactive and Active Ventor Route
    Route::controller(adminController::class)->group(function(){
        Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
        Route::post('/active/vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('/inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/inactive/vendor/approve', 'InactiveVendorApprove')->name('inactive.vendor.approve');

    });


        //Product Route
        Route::controller(productController::class)->group(function(){
            Route::get('/all/product', 'AllProduct')->name('all.product');
            Route::get('/add/product', 'AddProduct')->name('add.product');
            Route::post('/store/product' , 'StoreProduct')->name('store.product');
            Route::get('/edit/product/{id}' , 'EditProduct')->name('edit.product');
            Route::post('/update/product' , 'UpdateProduct')->name('update.product');
            Route::post('/update/product/thambnail' , 'UpdateProductThambnail')->name('update.product.thambnail');
            Route::post('/update/product/multiimage' , 'UpdateProductMultiimage')->name('update.product.multiimage');
            Route::get('/product/multiimg/delete/{id}' , 'MulitImageDelelte')->name('product.multiimg.delete');
            Route::get('/product/inactive/{id}' , 'ProductInactive')->name('product.inactive');
            Route::get('/product/active/{id}' , 'ProductActive')->name('product.active');
            Route::get('/delete/product/{id}' , 'ProductDelete')->name('delete.product');
    
        });

        // Slider All Route 
        Route::controller(sliderController::class)->group(function(){
            Route::get('/all/slider' , 'AllSlider')->name('all.slider');
            Route::get('/add/slider' , 'AddSlider')->name('add.slider');
            Route::post('/store/slider' , 'StoreSlider')->name('store.slider');
            Route::get('/edit/slider/{id}' , 'EditSlider')->name('edit.slider');
            Route::post('/update/slider' , 'UpdateSlider')->name('update.slider');
            Route::get('/delete/slider/{id}' , 'DeleteSlider')->name('delete.slider');
        
        });

        // Banner All Route 
        Route::controller(BannerController::class)->group(function(){
            Route::get('/all/banner' , 'AllBanner')->name('all.banner');
            Route::get('/add/banner' , 'AddBanner')->name('add.banner');
            Route::post('/store/banner' , 'StoreBanner')->name('store.banner');
            Route::get('/edit/banner/{id}' , 'EditBanner')->name('edit.banner');
            Route::post('/update/banner' , 'UpdateBanner')->name('update.banner');
            Route::get('/delete/banner/{id}' , 'DeleteBanner')->name('delete.banner');
        
        });


        Route::controller(CouponController::class)->group(function(){
            Route::get('/all/coupon' , 'AllCoupon')->name('all.coupon');
            Route::get('/add/coupon' , 'AddCoupon')->name('add.coupon');
            Route::post('/store/coupon' , 'StoreCoupon')->name('store.coupon');
            Route::get('/edit/coupon/{id}' , 'EditCoupon')->name('edit.coupon');
            Route::post('/update/coupon' , 'UpdateCoupon')->name('update.coupon');
            Route::get('/delete/coupon/{id}' , 'DeleteCoupon')->name('delete.coupon');
        
        });

        Route::controller(ShippingAreaController::class)->group(function(){
            Route::get('/all/division' , 'AllDivision')->name('all.division');
            Route::get('/add/division' , 'AddDivision')->name('add.division');
            Route::post('/store/division' , 'StoreDivision')->name('store.division');
            Route::get('/edit/division/{id}' , 'EditDivision')->name('edit.division');
            Route::post('/update/division' , 'UpdateDivision')->name('update.division');
            Route::get('/delete/division/{id}' , 'DeleteDivision')->name('delete.division');



        // Shipping District All Route 
            Route::get('/all/district' , 'AllDistrict')->name('all.district');
            Route::get('/add/district' , 'AddDistrict')->name('add.district');
            Route::post('/store/district' , 'StoreDistrict')->name('store.district');
            Route::get('/edit/district/{id}' , 'EditDistrict')->name('edit.district');
            Route::post('/update/district' , 'UpdateDistrict')->name('update.district');
            Route::get('/delete/district/{id}' , 'DeleteDistrict')->name('delete.district');


             // Shipping State All Route 
        
            Route::get('/all/state' , 'AllState')->name('all.state');
            Route::get('/add/state' , 'AddState')->name('add.state');
             Route::post('/store/state' , 'StoreState')->name('store.state');
             Route::get('/edit/state/{id}' , 'EditState')->name('edit.state');
             Route::post('/update/state' , 'UpdateState')->name('update.state');
             Route::get('/delete/state/{id}' , 'DeleteState')->name('delete.state');

            Route::get('/district/ajax/{division_id}' , 'GetDistrict');

      
        }); 


});//Admin Middleware


Route::middleware(['auth','roles:vendor'])->group(function(){
    
    Route::controller(vendorController::class)->group(function(){
        Route::get('/vendor/dashboard', 'VendorDashboard')->name('vendor.dashboard');
        Route::get('/vendor/logout', 'VendorLogout')->name('vendor.logout');
        Route::get('/vendor/profile', 'VendorProfile')->name('vendor.profile');
        Route::post('/update/vendor', 'UpdateVendor')->name('update.vendor');
        Route::get('/change/vendor/password', 'ChangeVendorPassword')->name('change.vendor.password');
        Route::post('/store/vendor/password', 'StoreVendorPassword')->name('store.vendor.password');
    });

    
    Route::controller(VendorProductController::class)->group(function(){
        Route::get('/all/vendor/product', 'AllVendorProduct')->name('all.vendor.product');
        Route::get('/add/vendor/product', 'AddVendorProduct')->name('add.vendor.product');
        Route::get('/vendor/subcategory/ajax/{category_id}' , 'GetSubCategoryVendor');
        Route::post('/store/vendor/product' , 'StoreVendorProduct')->name('store.vendor.product');

        Route::get('/edit/Vendor/product/{id}' , 'EditVendorProduct')->name('edit.vendor.product');
        Route::post('/update/vendor/product' , 'UpdateVendorProduct')->name('update.vendor.product');
        Route::post('/update/vendor/product/thambnail' , 'UpdateVendorProductThambnail')->name('update.vendor.product.thambnail');
        Route::post('/update/vendor/product/multiimage' , 'UpdateVendorProductMultiimage')->name('update.vendor.product.multiimage');
        Route::get('/vendor/product/multiimg/delete/{id}' , 'VendorMulitImageDelelte')->name('vendor.product.multiimg.delete');
        // Route::get('/vendor/product/inactive/{id}' , 'VendorProductInactive')->name('vendor.product.inactive');
        // Route::get('/vendor/product/active/{id}' , 'VendorProductActive')->name('vendor.product.active');
        Route::get('/vendor/delete/product/{id}' , 'VendorProductDelete')->name('vendor.delete.product');
    });

});


Route::middleware(['auth','roles:user'])->group(function(){

    Route::controller(UserController::class)->group(function(){
        Route::get('/dashboard', 'Dashboard')->name('user.dashboard');
        Route::get('/user/logout', 'UserLogout')->name('user.logout');
        Route::get('/user/profile', 'UserProfile')->name('user.profile');
        Route::post('/update/user', 'UpdateUser')->name('update.user');
        Route::post('/store/user/password', 'StoreUserPassword')->name('store.user.password');


    });

    Route::controller(WishlistController::class)->group(function(){
        Route::get('/wishlist' , 'AllWishlist')->name('wishlist');
        Route::get('/get-wishlist-product' , 'GetWishlistProduct');
        Route::get('/wishlist-remove/{id}' , 'WishlistRemove');
    
    }); 

    //Compare Route

    Route::controller(CompareController::class)->group(function(){
        Route::get('/compare', 'AllCompare')->name('compare');
        Route::get('/get-compare-product' , 'GetCompareProduct');
        Route::get('/compare-remove/{id}' , 'CompareRemove'); 
    });
    Route::controller(CartController::class)->group(function(){
        Route::get('/mycart' , 'MyCart')->name('mycart');
        Route::get('/get-cart-product' , 'GetCartProduct');
        Route::get('/cart-remove/{rowId}' , 'CartRemove');
        Route::get('/cart-decrement/{rowId}' , 'CartDecrement');
        Route::get('/cart-increment/{rowId}' , 'CartIncrement');
    
        /// Frontend Coupon Option
        Route::post('/coupon-apply', 'CouponApply');
        Route::get('/coupon-calculation', 'CouponCalculation');
        Route::get('/coupon-remove', 'CouponRemove');
    });


    
    
    
});


// public routes
Route::get('/become/vendor', [vendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [vendorController::class, 'VendorRegister'])->name('vendor.register');
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);


//Fontend routes
Route::controller(frontendController::class)->group(function(){
    Route::get('/', 'Frontend')->name('frontend');
    Route::get('/product/details/{id}/{slug}','ProductDetails');
    Route::get('/vendor/details/{id}/{name}','VendorDetails')->name('vendor.details');
    Route::get('/vendor/all', 'VendorAll')->name('vendor.all');
    Route::get('/product/category/{id}/{slug}','CategoryDetails')->name('category.details');
    Route::get('/product/subcategory/{id}/{slug}','SubcategoryDetails')->name('subcategory.details');
    // Product View Modal With Ajax
    Route::get('/product/view/modal/{id}', 'ProductViewAjax');
    
});

Route::controller(CartController::class)->group(function(){
    /// Add to cart store data
    Route::post('/cart/data/store/{id}', 'AddToCart');

    // Get Data from mini Cart
    Route::get('/product/mini/cart', 'AddMiniCart');
    Route::get('/minicart/product/remove/{rowId}', 'RemoveMiniCart');
    /// Add to cart store data For Product Details Page 
    Route::post('/dcart/data/store/{id}', 'AddToCartDetails');
});

/// Wishlist Store Data
Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishList']);

//Compare Route

Route::controller(CompareController::class)->group(function(){
    Route::post('/add-to-compare/{product_id}', 'AddToCompare');
});




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
