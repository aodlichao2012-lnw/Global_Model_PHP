<?php 
interface IAction{
    public function execute($sqls ,  $connectionstring);
    public function remove($sqls ,  $connectionstring);
    public function Select($sqls ,  $connectionstring);
    public function SelectAll( $connectionstring);
    public function RamdomNumber($start , $end);
}
?>