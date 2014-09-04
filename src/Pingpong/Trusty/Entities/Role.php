<?php namespace Pingpong\Trusty\Entities;

use Pingpong\Trusty\Traits\SlugableTrait;
use \Config;

class Role extends \Eloquent
{
	use SlugableTrait;
	
	/**
	 * Fillable property.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'description'];

	/**
	 * Relation to "Permission".
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany(__NAMESPACE__ . '\\Permission')->withTimestamps();
	}

	/**
	 * Relation to "User".
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany($this->config->get('auth.model'))->withTimestamps();
	}

	/**
	 * Check whether the user role has a given permission.
	 *
	 * @param  string  $permission
	 * @return boolean
	 */
	public function can($permission)
	{
		return in_array($permission, array_fetch($this->permissions->toArray(), 'slug'));
	}
}