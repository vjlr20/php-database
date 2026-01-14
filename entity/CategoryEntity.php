<?php
    // Usamos la clase Model para poder interpretar Eloquent
    use Illuminate\Database\Eloquent\Model;

    // Clase interpreta la tabla de "categorías"
    class CategoryEntity extends Model
    {       
        // Indica la tabla que esta interpretando
        protected $table = "categorias";

        // Desahabilitamos los timestamps automáticos de Eloquent
        public $timestamps = false;

        // Indica que campos se pueden o deben ser llenados
        public $fillable = array(
            'nombre',
            'descripcion',
            'estado',
            'fecha_creacion', // created_at
            'fecha_actualizacion', // updated_at
            'fecha_borrado' // deleted_at
        );
    }
