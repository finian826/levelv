<?php

namespace LevelV\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSkillz extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'member_skillz';
    public $incrementing = false;
    protected static $unguarded = true;
}
