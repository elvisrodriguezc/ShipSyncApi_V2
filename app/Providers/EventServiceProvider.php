<?php

namespace App\Providers;

use App\Models\Entity;
use App\Models\Guidecarrier;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Purchase;
use App\Models\Requirement;
use App\Models\Requirementdetail;
use App\Models\Transfer;
use App\Models\Unity;
use App\Models\Warehousekardex;
use App\Observers\EntityObserver;
use App\Observers\GuidecarrierObserver;
use App\Observers\OrderitemObserver;
use App\Observers\OrderObserver;
use App\Observers\PurchaseObserver;
use App\Observers\RequirementdetailObserver;
use App\Observers\RequirementObserver;
use App\Observers\TransferObserver;
use App\Observers\UnityObserver;
use App\Observers\WarehousekardexObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
        Orderitem::observe(OrderitemObserver::class);
        Guidecarrier::observe(GuidecarrierObserver::class);
        Purchase::observe(PurchaseObserver::class);
        Warehousekardex::observe(WarehousekardexObserver::class);
        Requirement::observe(RequirementObserver::class);
        Requirementdetail::observe(RequirementdetailObserver::class);
        Transfer::observe(TransferObserver::class);
        Unity::observe(UnityObserver::class);
        Entity::observe(EntityObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
