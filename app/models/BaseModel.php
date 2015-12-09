<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    /**
     * =====================================================
     * Base Model for validations and any extra functions
     * =====================================================
     */

    /**
     * Model validator
     *
     * @var BaseValidator
     */
    protected $validator;

    /**
     * Default Validation Rules
     */
    protected $rules = [
        'create' => [

        ],
        'update' => [

        ],
    ];

    /**
     * Model errors
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Guarded attributes
     * By default it's only PK
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Default hidden attributes
     * These attributes will be excluded from JSON
     */
    protected $hidden = ['pivot', 'password'];

    /**
     * Returns errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Returns errors in line from array of errors
     *
     * @return string
     */
    public function getErrorsInLine()
    {
        $message = '';
        foreach($this->errors as $error){
            if (is_array($error)){
                foreach($error as $errorMessage){
                    $message .= $errorMessage.' ';
                }
                continue;
            }
            $message .= $error.' ';
        }

        return $message;
    }

    /**
     * Gets the table name
     * @return string The table name used for this model
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * Get table column names
     *
     * @return array
     * @throws Exception
     */
    public function getColumnNames()
    {
        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$this->table."'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $query = 'SHOW COLUMNS FROM '.$this->table;
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->table);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach(DB::select($query) as $column)
        {
            $columns[] = $column->$column_name;
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }

    public function slugify($title, $s = 'slug')
    {
        $slug = Str::slug($title);
        $slugCount = count( $this->whereRaw($s." REGEXP '^{$slug}(-[0-9]*)?$'")->get() );

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    // where condition by field
    function scopeByField($query, $field, $value)
    {
        return $query->where($field, '=', $value);
    }

    /**
     * Quick way to find and return a model by user_id field
     * @param  [[Type]] $query [[Description]]
     * @param  int $id    the user_id
     * @return [[Type]] [[Description]]
     */
    function scopeByUser($query, $id)
    {
        return $query->where('user_id', '=', $id)->first();
    }

    // by list of fields with =
    function scopeFilters($query, $filters)
    {
        foreach($filters as $k=>$v)
        {
            $query->byField($k, $v);
        }
        return $query;
    }

    // fast scope for ordering DESC
    function scopeDesc($query, $field)
    {
        return $query->orderBy($field, 'desc');
    }

    // fast scope for ordering asc
    function scopeAsc($query, $field)
    {
        return $query->orderBy($field, 'asc');
    }


    // search by date
    function scopeToday($query, $field)
    {
        return $query->whereRaw("DATE(".$field.") = CAST(". date("'Y-m-d'", time())." as DATE)");
    }

    // search by date
    function scopeByDay($query, $field, $value)
    {
        return $query->whereRaw("DATE(".$field.") = CAST(". date("'Y-m-d'", strtotime($value))." as DATE)");
    }

    // search by range between dates
    function scopeByDayRange($query, $field, $value1, $value2)
    {
        return $query->whereRaw(
            "( DATE(".$field.") >= CAST(". date("'Y-m-d'", strtotime($value1))." as DATE) 
            AND DATE(".$field.") <= CAST(". date("'Y-m-d'", strtotime($value2))." as DATE) )");
    }

    // scope by field like
    function scopeByFieldLike($query, $field, $value)
    {
        return $query->where($field , 'like', "%".$value."%");
    }

    // scope by list for field LIKE
    function scopeByFieldListLike($query, $fields, $value)
    {
        $query->where(
            function($query) use ($fields, $value){
                foreach($fields as $field)
                {
                    $query->orWhere($field , 'like', "%".$value."%");
                }
            });
        return $query;
    }

    /**
     * Merge data in the model with the data from input. Rewrite with keys from input.
     * It checks each key at input data for fillable in the model
     * @param $data
     * @return array model data after merging
     */
    public function mergeData($data)
    {
        foreach($data as $field=>$value)
        {
            if ($this->isFillable($field))
            {
                $this->{$field} = $value;
            }
        }
        return $this->toArray();
    }

    /**
     * Get instance with initiated data from array
     *
     * @param $data
     *
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function instanceFromArray($data)
    {
        if ( isset($data['id']) )
        {
            $object = static::find($data['id']);
        }
        if ( !isset($object) )
        {
            // return empty object
            $class = get_called_class();
            $object = new $class;
        }
        return $object;
    }

    /**
     * Returns an instance of the validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * Sets model validator object
     *
     * @param Validator $validator
     *
     * @return $this
     */
    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Validates provided data for model
     *
     * @param array $data
     * @param string $type
     *
     * @throws Exception
     *
     * @return bool
     */
    public function validate(array $data, $type = 'create')
    {
        $this->validator = Validator::make($data, $this->rules[$type]);
        $validationResult = $this->validator->passes();
        if (!$validationResult)
        {
            $this->errors = $this->validator->messages();
        }

        return $validationResult;
    }   
}