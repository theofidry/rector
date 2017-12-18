### How to use on PHP < 7.1 or Incompatible Composer Dependencies

You must have an isolated environment with PHP 7.1 (for example in a Docker container). When you have it then run following command:

```
composer create-project rector/rector:@dev path-to-rector
```

You will be able to run Rector like this:

```
path-to-rector/bin/rector <arguments>
```

Now you can read more in [README](../README.md/#install).