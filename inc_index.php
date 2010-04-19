Hello Hakodate Framework!
<?
/* get the first row */
hakoVarDump(get('select * from books'));
/* get first column of the first row*/
hakoVarDump(g('select book_name from books'));

/* get all rows */
hakoVarDump(getAll('select * from books'));
/* get first columns of all rows */
hakoVarDump(gAll('select book_name from books'));

