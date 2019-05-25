<?php


namespace Eslym\HasPerm;


use Illuminate\Support\Arr;

/**
 * Trait HasPerm
 * @package Eslym\HasPerm
 *
 * @mixin Permissionable
 */
trait HasPerm
{
    /**
     * @param string $permission
     * @param bool|null $value
     * @return bool|$this
     */
    public function perm(string $permission, ?bool $value = null){
        $perms = $this->getPermissions();
        $parts = explode('.', $permission);
        if($value !== null){
            if($value){
                Arr::set($perms, $permission, $value);
            } else {
                Arr::forget($perms, $permission);
            }
            while(strlen($permission) > 0){
                if(Arr::get($perms, $permission) == []){
                    Arr::forget($perms, $permission);
                    $permission = preg_replace('/(?:\.|^)[^\.]*$/', '', $permission);
                } else {
                    break;
                }
            }
            $this->setPermissions($perms);
            return $this;
        }
        foreach ($parts as $part){
            if(!isset($perms[$part])){
                return false;
            }
            if($perms[$part] === true){
                return true;
            }
            if(!is_array($perms[$part])){
                return false;
            }
            $perms = $perms[$part];
        }
        return false;
    }
}