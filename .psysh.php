<?php
// Autoload all classes in app/ and create aliases for their base names, handling conflicts with prefixes
$directory = __DIR__ . '/app';
$prefixed = [];

if (is_dir($directory)) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($rii as $file) {
        if ($file->isDir() || $file->getExtension() !== 'php') continue;
        $path = $file->getPathname();
        // Only process files that contain a class, interface, trait, or enum
        $contents = file_get_contents($path);
        if (
            strpos($contents, 'class ') === false &&
            strpos($contents, 'interface ') === false &&
            strpos($contents, 'trait ') === false &&
            strpos($contents, 'enum ') === false
        ) {
            continue;
        }
        $relativePath = substr($path, strlen($directory) + 1, -4); // Remove app/ and .php
        $class = 'App\\' . str_replace(['/', '\\'], '\\', $relativePath);
        $class = str_replace('\\\\', '\\', $class); // Fix double backslashes
        $alias = basename($relativePath);

        // If alias already exists, prefix with parent directory
        if (class_exists($alias) || function_exists($alias)) {
            $parts = explode(DIRECTORY_SEPARATOR, $relativePath);
            if (count($parts) > 1) {
                $prefix = $parts[count($parts) - 2];
                $prefixedAlias = $prefix . '_' . $alias;
            } else {
                $prefixedAlias = 'App_' . $alias;
            }
            if (!class_exists($prefixedAlias) && class_exists($class)) {
                class_alias($class, $prefixedAlias);
                $prefixed[] = [$prefixedAlias, $class];
            }
        } else {
            if (class_exists($class)) {
                class_alias($class, $alias);
            }
        }
    }
}

// Notify user about prefixed aliases
if (!empty($prefixed)) {
    echo "\n[.psysh.php] The following class aliases were prefixed due to conflicts:\n";
    foreach ($prefixed as [$alias, $class]) {
        echo "  $alias => $class\n";
    }
    echo "\n";
}