<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    //ini adalah method untuk menghandle relationship
    public function parent()
    {

        //KARENA RELASINYA DENGAN DIRINYA SENDIRI, MAKA CLASS MODEL DIDALM belongsTo() ADALAH NAMA CLASSNYA SENDIRI YAKNI CATEGORY
        //belongsTo DIGUNAKAN UNTUK REFLEKSI KE DATA INDUKNYA
        return $this->belongsTo(Category::class);
    }

    //UNTUK LOCAL SCOPE NAMA METHODNYA DIAWAL DENGAN KATA scope DAN DIIKUTI DENGAN NAMA METHOD YANG DIINGINKAN
    //CONTOH: scopeNamaMethod()
    public function scopeGetParent($query)
    {

        //SEMUA QUERY YANG MENGGUNAKAN LOCAL SCOPE INI AKAN SECARA OTOMATIS DITAMBAHKAN KONDISI whereNul('parent_id')
        return $query->whereNull('parent_id');
    }

    protected $fillable = ['name', 'parent_id', 'slug'];

    // mutator
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // accessor
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function child()
    {
        // menggunakan relasi one to many dengan foreign key parent_id
        return $this->hasMany(Category::class, 'parent_id');
    }
}