# PHP-CS-FIXER : Custom fixers

[![Build Status](https://travis-ci.org/PedroTroller/PhpCSFixer-Custom-Fixers.svg?branch=master)](https://travis-ci.org/PedroTroller/PhpCSFixer-Custom-Fixers)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PedroTroller/PhpCSFixer-Custom-Fixers/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PedroTroller/PhpCSFixer-Custom-Fixers/?branch=master)

# Installation

```bash
composer require pedrotroller/php-cs-custom-fixer --dev
```

### Configuration

```php
// .php_cs
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->registerCustomFixers(new PedroTroller\CS\Fixer\Fixers())
    // ...
;

return $config;
```

# Fixers


## PedroTroller/line_break_between_method_arguments

Function methods MUST be splitted by a line break

### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/line_break_between_method_arguments' => [ "max-args" => 4, "max-length" => 80 ],
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
-    public function fun2($arg1, array $arg2 = [], \ArrayAccess $arg3 = null, bool $bool = true)
-    {                                                                           //
+    public function fun2(                                                       //
+        $arg1,                                                                  //
+        array $arg2 = [],                                                       //
+        \ArrayAccess $arg3 = null,                                              //
+        bool $bool = true                                                       //
+    ) {                                                                         //
         return;                                                                 //
     }                                                                           //
                                                                                 //
-    public function fun3(                                                       //
-        $arg1,                                                                  //
-        array $arg2 = []                                                        //
-    ) {                                                                         //
+    public function fun3($arg1, array $arg2 = [])                               //
+    {                                                                           //
                                                                                 //
```


## PedroTroller/line_break_between_statements

Transform multiline docblocks with only one comment into a singleline docblock.

### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/line_break_between_statements' => true,
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
+                                                                                //
         foreach (['foo', 'bar'] as $str) {                                      //
             // ...                                                              //
         }                                                                       //
+                                                                                //
         if (true === false) {                                                   //
             // ...                                                              //
         }                                                                       //
-                                                                                //
                                                                                 //
```


## PedroTroller/single_line_comment

PHPSpec spec functions MUST NOT have a public scope.

### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/single_line_comment' => [ "action" => "expanded" ],
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
-    /** @var string */                                                          //
+    /**                                                                         //
+     * @var string                                                              //
+     */                                                                         //
                                                                                 //
```
### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/single_line_comment' => [ "action" => "collapsed" ],
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
-    /**                                                                         //
-     * @var string                                                              //
-     */                                                                         //
+    /** @var string */                                                          //
                                                                                 //
```
### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/single_line_comment' => [ "action" => "collapsed", "types" => [ "@var", "@return" ] ],
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
-    /**                                                                         //
-     * @var string                                                              //
-     */                                                                         //
+    /** @var string */                                                          //
     private $prop1;                                                             //
                                                                                 //
-    /**                                                                         //
-     * @return null                                                             //
-     */                                                                         //
+    /** @return null */                                                         //
                                                                                 //
```


## PedroTroller/phpspec

PHPSpec spec functions MUST NOT have a public scope.

### Configuration

```php
<?php

$config = PhpCsFixer\Config::create()
    // ...
    ->setRules([
        // ...
        'PedroTroller/phpspec' => true,
        // ...
    ])
    // ...
;

return $config;
```

### Fixes

```diff
--- Original                                                                     // 80 chars
+++ New                                                                          //
@@ @@                                                                            //
-    public function let($file) {                                                //
+    function let($file) {                                                       //
         return;                                                                 //
     }                                                                           //
                                                                                 //
-    public function letGo($file) {                                              //
+    function letGo($file) {                                                     //
         return;                                                                 //
     }                                                                           //
                                                                                 //
-    public function it_is_a_spec($file) {                                       //
+    function it_is_a_spec($file) {                                              //
                                                                                 //
```


# Contributions

## Run tests

```bash
composer tests
```
