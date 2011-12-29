Language Loader
===============

The purpose of this project is to deliver a simple, lazy-loading language 
loader, which helps make localized php apps.

It is designed to be data-source agnostic, but a file-system based 
implementation will be included.

All that is required of a sub-implementation is to override the loadTable
function, which will be called the first time a specific table is requested.
