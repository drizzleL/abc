<?php

namespace App\Models;

use EstGroupe\Taggable\Model\Tag as TaggableTag;
use EstGroupe\Taggable\Contracts\TaggingUtility;
use DB;

class Tag extends TaggableTag
{
    /**
     * Set the name of the tag : $tag->name = 'myname';
     *
     * @param string $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = app(TaggingUtility::class)->normalizeTagName($value);
    }


    public function renameTag($name)
    {
        if ($this->name == $name) {
            return $this;
        }
        $tag = self::byTagName($name)->first();
        // 合并或重命名
        if ($tag) {
            DB::statement("update IGNORE taggables set tag_id = {$tag->id} where tag_id = {$this->id}");
            $tag->count = DB::table('taggables')->where('tag_id', $tag->id)->count();
            $tag->save();
            $this->delete();
        } else {
            $this->name = $name;
            $this->save();
            $tag = $this;
        }
        return $tag;
    }

}
