## Create database
```sql
CREATE DATABASE slim4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Migrate
```
composer run migration:migrate
```

## Populate with data seed
```
composer run migration:seed
```
