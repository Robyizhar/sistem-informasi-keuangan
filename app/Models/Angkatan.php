<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class Angkatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = 'm_angkatan';
    protected $fillable = ['entry_year', 'name', 'dsp_cost', 'spp_cost', 'created_by', 'updated_by', 'deleted_by'];
    public $appends = [
        'kelas',
        'kelas_label',
    ];

    private function generateClass () {
        $entry_year = date_create_from_format('Y-m-d', $this->entry_year."-06-01");
        $current_year = date_create_from_format('Y-m-d', date('Y-m-d'));
        return (array) date_diff($entry_year, $current_year);
    }

    public function getKelasAttribute() {

        $result_year = $this->generateClass();
        return $result_year['y']+1;
    }

    public function getKelasLabelAttribute() {

        $result_year =  $this->generateClass();

        if ($result_year['y'] === 0) {
            return 'Kelas VII';
        } else if ($result_year['y'] === 1){
            return 'Kelas VIII';
        } else if ($result_year['y'] === 2) {
            return 'Kelas IX';
        } else {
            return 'Sudah Lulus';
        }
    }
}
