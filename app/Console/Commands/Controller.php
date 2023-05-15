<?php 
namespace App\Console\Commands;

/**
 * 
 */
trait Controller
{
    public function makeController($files, $modelClassName, $fields, $table_name, $relatedModel) {
        $view_folder = strtolower($modelClassName);

        $stub = $files->get(base_path('stubs/controller.stub'));
        $stub = str_replace(['{{ DummyClass }}', '{{ model }}'], $modelClassName, $stub);
        $stub = str_replace('{{ DummyNamespace }}', $this->DummyNamespace, $stub);
        $stub = str_replace('{{ rootRelatedModalNameSpace }}', $relatedModel, $stub);
        /**
         * for index function 
         */
        $stub = str_replace('{{ title }}', str_replace(['-','_'], ' ', $modelClassName), $stub);
        $stub = str_replace('{{ view_folder }}', $view_folder, $stub);
        $stub = str_replace('{{ view_index }}', 'index', $stub);
        $datatable_where_text = '';
        $validation_fields = '';
        $insert_fields = '';
        $i = 0;
        if (isset($fields) && !empty($fields)) {
            foreach ($fields as $fkey => $fitems) {
                $type = explode(':', $fitems);
                switch ($type[0]) {
                    case 'string':
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            if( $i == 0 ) {
                                $datatable_where_text .= '$q->where(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            } else {
                                $datatable_where_text .= '->orWhere(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            }
                            $id = '$id';
                            if( isset( $type[2] ) && $type[2] == 'unique') {
                                $validation_fields .= '\''.$fkey.'\' => \'required|string|unique:'.$table_name.','.$fkey.',' . $id .',id,deleted_at,NULL\'';
                            } else {
                                $validation_fields .= '\''.$fkey.'\' => \'required|string\'';
                            }
                            $insert_fields .= '$ins[\''.$fkey.'\'] = $request->'.$fkey.';';
                        }
                        break;
                    case 'int':
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            if( $i == 0 ) {
                                $datatable_where_text .= '$q->where(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            } else {
                                $datatable_where_text .= '->orWhere(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            }
                            $id = '$id';
                            if( isset( $type[2] ) && $type[2] == 'unique') {
                                $validation_fields .= '\''.$fkey.'\' => \'required|string|unique:'.$table_name.','.$fkey.',' . $id .',id,deleted_at,NULL\'';
                            } else {
                                $validation_fields .= '\''.$fkey.'\' => \'required|string\'';
                            }

                            $insert_fields .= '$ins[\''.$fkey.'\'] = $request->'.$fkey.';';
                        }
                        break;
                    
                    case 'text':
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            if( $i == 0 ) {
                                $datatable_where_text .= '$q->where(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            } else {
                                $datatable_where_text .= '->orWhere(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            }
                            $insert_fields .= '$ins[\''.$fkey.'\'] = $request->'.$fkey.';';
                            $validation_fields .= '\''.$fkey.'\' => \'required|string\'';
                        }
                        break;
                    case 'longText':
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            if( $i == 0 ) {
                                $datatable_where_text .= '$q->where(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            } else {
                                $datatable_where_text .= '->orWhere(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$keywords}%")';
                            }
                            $insert_fields .= '$ins[\''.$fkey.'\'] = $request->'.$fkey.';';
                            $validation_fields .= '\''.$fkey.'\' => \'required|string\'';
                        }
                        break;
                    case 'date':
                        if (isset($type[1]) && !empty($type[1]) && $type[1] == 'required') {
                            
                            if( $i == 0 ) {
                                $datatable_where_text .= '$q->whereDate(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$date}%")';
                            } else {
                                $datatable_where_text .= '->orWhereDate(\''.$table_name.'.'.$fkey.'\',\'like\',"%{$date}%")';
                            }
                            $insert_fields .= '$ins[\''.$fkey.'\'] = date(\'Y-m-d\', strtotime($request->'.$fkey.');';
                            $validation_fields .= '\''.$fkey.'\' => \'required|string\'';
                        }
                        break;
                    default:
                        
                        break;
                }

                $i++;
               
            }
            $datatable_where_text .= '->orWhereDate(\''.$table_name.'.created_at\',\'like\',"%{$date}%");';
        }
        
        $insert_fields .= '$ins[\'status\'] = $request->status ? \'active\' : \'inactive\';';
        $insert_fields .= '$ins[\'addedBy\'] = auth()->user()->id;';
        
        $stub = str_replace('{{ search_datatable_where }}', $datatable_where_text, $stub);
        $stub = str_replace('{{ $validation_fields }}', $validation_fields, $stub);
        $stub = str_replace('{{ $insert_fields }}', $insert_fields, $stub);
        return $stub;
        
    }
}


?>