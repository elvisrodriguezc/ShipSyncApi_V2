<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Guidecarrier extends Model
{
    use HasFactory;
    protected $fillable = [
        "company_id",
        "user_id",
        "numerator_id",
        "number",
        "release_date",
        "transfer_date",
        "sender_id",
        "senderbranch_id",
        "destination_id",
        "destinationbranch_id",
        "driver_id",
        "vehicle_id",
        "tercero_id",
        "subcontratado_id",
        "tipoindicador_id",
        "pesobruto",
        "nota",
        "numTicket",
        "fecRecepcion",
        "codRespuesta",
        "indCdrGenerado",
        "numError",
        "desError",
        "arcCdr",
        "filename",
        "hash",
        "status",
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function numerator(): BelongsTo
    {
        return $this->belongsTo(Numerator::class, 'numerator_id');
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'sender_id');
    }
    public function senderbranch(): BelongsTo
    {
        return $this->belongsTo(Entitiebranch::class, 'senderbranch_id');
    }
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'destination_id');
    }
    public function destinationbranch(): BelongsTo
    {
        return $this->belongsTo(Entitiebranch::class, 'destinationbranch_id');
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    public function tercero(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'tercero_id');
    }
    public function subcontratado(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'subcontratado_id');
    }
    public function tipoindicador(): BelongsTo
    {
        return $this->belongsTo(Typevalue::class, 'tipoindicador_id');
    }
    public function items()
    {
        return $this->hasMany(Guidecarrieritem::class);
    }
    public function documents()
    {
        return $this->hasMany(Guidecarrierdocs::class);
    }
}
