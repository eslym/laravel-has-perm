<?php


namespace Eslym\HasPerm;


interface Permissionable
{
    public function getPermissions(): array;

    public function setPermissions(array $permissions);

    /**
     * @param string $permission
     * @param bool|null $value
     * @return bool|$this
     */
    public function perm(string $permission, ?bool $value = null);
}