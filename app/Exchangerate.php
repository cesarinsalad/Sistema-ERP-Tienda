<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exchangerate
 *
 * @property int $id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchangerate whereValue($value)
 * @mixin \Eloquent
 */
class Exchangerate extends Model
{
    protected $fillable = [
        'value'
    ];

    /**
     * Fetch and update the exchange rate of the day using ve.dolarapi.com
     *
     * @return Exchangerate
     */
    public static function updateTodayRate()
    {
        $latest = self::latest('created_at')->first();

        // If the latest rate was created today, use it directly
        if ($latest && $latest->created_at->isToday()) {
            return $latest;
        }

        try {
            // Fetch rate from ve.dolarapi.com via standard Laravel Http client (or fallback)
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get('https://ve.dolarapi.com/v1/dolares/oficial');
            if ($response->successful()) {
                $data = $response->json();
                $promedio = floatval($data['promedio'] ?? 0);
                if ($promedio > 0) {
                    return self::create(['value' => $promedio]);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error fetching exchange rate: ' . $e->getMessage());
        }

        // Return latest fallback, or create a hardcoded fallback of 36.0 if table is empty
        return $latest ?: self::create(['value' => 36.0]);
    }

    public static function fetchForceUpdate()
    {
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(5)->get('https://ve.dolarapi.com/v1/dolares/oficial');
            if ($response->successful()) {
                $data = $response->json();
                $promedio = floatval($data['promedio'] ?? 0);
                if ($promedio > 0) {
                    return self::create(['value' => $promedio]);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error forcing exchange rate fetch: ' . $e->getMessage());
        }
        return null;
    }
}
