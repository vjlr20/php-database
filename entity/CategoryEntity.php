<?php
    // Usamos la clase Model para poder interpretar Eloquent
    use Illuminate\Database\Eloquent\Model;

    // Clase interpreta la tabla de "categorías"
    class CategoryEntity extends Model
    {   
        protected $table = "categorias";
    }
