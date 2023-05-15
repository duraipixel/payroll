<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class Crud extends Command
{
    use Controller;
    protected $signature = 'crud:generate {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $files;
    protected $DummyNamespace = 'App\Http\Controllers';
    protected $DummyRootNamespaceModels = 'App\Models';

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');
        $modelClassName = Str::studly($modelName);
        $modelVariableName = Str::camel($modelName);
        $table_name = Str::plural($modelName);

        $fields = [];

        while (true) {
            $fieldName = $this->ask('Enter the field name (leave blank to stop adding fields)');
            if (empty($fieldName)) {
                break;
            }
            $fieldType = $this->ask('Enter the field type (e.g. string:required, int:null, unsignedInt:null.)');
            $fields[$fieldName] = $fieldType;
        }

        $this->generateController($modelClassName, $fields, $table_name, 'App\Models\Test');
        die;

        $fillable = $this->generateMigration($fields, $table_name, $modelClassName);
        // $this->call('migrate');
        // $fillable_string = 'protected $fillable = '.print_r($fillable_array).';';
        $DummyNamespace = $this->DummyNamespace;
        $DummyRootNamespaceModels = $this->DummyRootNamespaceModels;
        // Replace placeholders with dynamic content for the model file
        $modal_stub = $this->files->get(base_path('stubs/model.stub'));
        $modal_stub = str_replace('DummyClass', $modelClassName, $modal_stub);
        $modal_stub = str_replace('DummyNamespace', $DummyRootNamespaceModels, $modal_stub);
        $modal_stub = str_replace('{{fillable}}', '\''.implode('\',\'', $fillable).'\'', $modal_stub);
        $this->generateFile(app_path("Models/{$modelClassName}.php"), $modal_stub);

        $rootRelatedModalNameSpace = 'App/Models/'.$modelClassName;
        $this->generateController($modelClassName, $fields, $table_name,$rootRelatedModalNameSpace);
        die;
       
        // dd($stub);
    }

    private function generateMigration($fields, $table_name, $modelClassName)
    {
        // $tableName = $this->ask('Enter the name of the table');
        $fillable = [];
        $fileName = date('Y_m_d_His') . '_' . strtolower($table_name) . '.php';
        $migration_text = '';
        if (isset($fields) && !empty($fields)) {
            foreach ($fields as $fkey => $fitems) {
                $type = explode(':', $fitems);
                $fillable[] = $fkey;
                switch ($type[0]) {
                    case 'string':
                        $migration_text .= '$table->string(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'int':
                        $migration_text .= '$table->integer(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'unsignedInt':
                        $migration_text .= '$table->unsignedBigInteger(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'text':
                        $migration_text .= '$table->text(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'longText':
                        $migration_text .= '$table->longText(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'date':
                        $migration_text .= '$table->date(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    case 'timestamp':
                        $migration_text .= '$table->timestamp(\'' . $fkey . '\')';
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            $migration_text .= ';';
                        } else {
                            $migration_text .= '->nullable();';
                        }
                        break;
                    default:
                        $this->error("datatype is not valid");
                        die;
                        break;
                }
                if ($fitems == 'string') {

                    $migration_text .= '$table->string(\'' . $fkey . '\');';
                }
            }
        }
        $migration_text .= '$table->enum("status", ["active", "inactive"])->default(\'active\');';
        $migration_text .= '$table->unsignedBigInteger("addedBy")->nullable();';

        $migrate_stub = $this->files->get(base_path('stubs/migration.create.stub'));
        $migrate_stub = str_replace('{{ table }}', $table_name, $migrate_stub);
        $migrate_stub = str_replace('{{ table_fields }}', $migration_text, $migrate_stub);
        $migrate_file = date('Y_m_d_His') . '_' . 'create_' . strtolower($modelClassName) . '_table';
       
        $this->generateFile(base_path("database/migrations/{$migrate_file}.php"), $migrate_stub);
        return $fillable;
    }

    private function generateModel($contents)
    {
        $DummyNamespace = 'App\Models';
    }

    private function generateController( $modelClassName, $fields, $table_name, $relatedModel ) {

        $stub = $this->makeController($this->files, $modelClassName, $fields, $table_name, $relatedModel );
        $this->generateFile(app_path("Http/Controllers/{$modelClassName}Controller.php"), $stub);

    }
    private function generateViews() {

    }


    private function generateFile($path, $contents)
    {
        if ($this->files->exists($path)) {
            $this->error("File {$path} already exists.");
            return;
        }

        $this->files->put($path, $contents);

        $this->info("File {$path} generated successfully.");
    }
}
