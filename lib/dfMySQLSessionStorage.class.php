<?php

  /**
   * dfMySQLSessionStorage
   * This is patched version of sfMySQLSessionStorage for symfony 1.0.
   *
   * patch from:
   *  http://www.3bancho.com/diary/20071102.html#p03
   *
   *
   *
   */


class dfMySQLSessionStorage extends sfMySQLSessionStorage
{
    public function sessionWrite($id, &$data){
        $database    = $this->getParameterHolder()->get('database');
        // get table/column
        $db_table    = $this->getParameterHolder()->get('db_table');
        $db_data_col = $this->getParameterHolder()->get('db_data_col', 'sess_data');
        $db_id_col   = $this->getParameterHolder()->get('db_id_col', 'sess_id');
        $db_time_col = $this->getParameterHolder()->get('db_time_col', 'sess_time');
       
        // cleanup the session id and data, just in case
        $id   = mysql_real_escape_string($id, $this->resource);
        $data = mysql_real_escape_string($data, $this->resource);
       
        // delete the record associated with this id
        $sql = 'UPDATE '.$db_table.' ' .
            'SET '.$db_data_col.' = \''.$data.'\', ' .
            $db_time_col.' = NOW() ' .
            'WHERE '.$db_id_col.' = \''.$id.'\'';
        
        // select our database
        if ($database != null && !@mysql_select_db($database, $this->resource)){
            // can't select the database
            $error = 'Failed to select MySQLDatabase "%s"';
            $error = sprintf($error, $database);
            
            throw new sfDatabaseException($error);
        }


        if (@mysql_query($sql, $this->resource)){
            return true;
        }

        
        // failed to write session data
        $error = 'MySQLSessionStorage cannot write session data for id "%s"';
        $error = sprintf($error, $id);
        $error .= "\n".mysql_error($this->resource)."\n".$database;
        throw new sfDatabaseException($error);
    }
}