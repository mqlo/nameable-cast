This package works best with the [mqlo/nameable](https://github.com/mqlo/nameable/) package for Laravel, Lumen.

## Example #1
### Post
```php
    /**
     * @property PostStatus $status
    */
    class Post extends Model
    {
        protected $casts = [
            'status' => PostStatusCast::class,
        ];
    ...
    }
```
### PostStatus
```php
    use Mqlo\Nameable\Nameable;

    class PostStatus extends Nameable
    {
        public const DRAFT = 'draft';
        public const PUBLISHED = 'published';

        protected static array $all = [
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
        ];

        public static function draft(): self
        {
            return new self(self::DRAFT);
        }

        public static function published(): self
        {
            return new self(self::PUBLISHED);
        }

        public function isDraft(): bool
        {
            return $this->name === self::DRAFT;
        }
        
        public function isPublished(): bool
        {
            return $this->name === self::PUBLISHED;
        }
    }
```
### PostStatusCast
```php
    use Mqlo\NameableCast\NameableCast;

    class PostStatusCast extends NameableCast
    {
        protected function nameableClass(): string
        {
            return PostStatus::class;
        }
    }
```
### Post create
```php

    $post = new Post();
    $post->status = PostStatus::draft();
    $post->save();

    //or
    
    $post = Post::create(['status' => PostStatus::DRAFT]);

    //validation
    $this->validate($request, [
        'title' => 'required|string|max:255',
        'status' => 'required|in:' . implode(',', PostStatus::all(false))
    ]);
```
#### Using
```php
    echo $post->status->isDraft() ? 'This post draft.' : '...'; 

    PostStatus::all(true); // with descriptions
    PostStatus::all(false); // without descriptions

    return $post;
        
    [
        ...,
        'status' => [
            'name' => 'draft',
            'label' => 'Draft'
        ]
    ]
````
### Example tables
- tokens

| id | type | expire |
| ------ | ------ | ------ |
| 1 | email_confirmation | 2020-10-01 19:00:00 |
| 2 | password_reset | 2020-10-01 19:30:00 |
|...| ... | ... |

- posts

| id | title | status |
| ------ | ------ | ------ |
| 1 | Post 1 | draft |
| 2 | Post 2 | published |
|...| ... | ... |