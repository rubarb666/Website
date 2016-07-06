<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Crown\DateTime\RhubarbDateTime;
use Rhubarb\Stem\Filters\AndGroup;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Filters\OrGroup;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\IntegerColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
use Rhubarb\Stem\Schema\ModelSchema;

/**
 * @parameter integer           $CommentID
 * @parameter integer           $ParentCommentID
 * @parameter string            $UrlPath
 * @parameter string            $Email
 * @parameter string            $Name
 * @parameter string            $Body
 * @parameter likes             $Likes
 * @parameter RhubarbDateTime   $Date
 */
class Comment extends Model
{
    /**
     * Returns the schema for this data object.
     *
     * @return \Rhubarb\Stem\Schema\ModelSchema
     */
    protected function createSchema()
    {
        $schema = new ModelSchema("tblComment");
        $schema->addColumn(
            new AutoIncrementColumn("CommentID"),
            new IntegerColumn("ParentCommentID", 0),
            new StringColumn("UrlPath", 50),
            new StringColumn("Email", 50),
            new StringColumn("Name", 50),
            new StringColumn("Body", 10000),
            new IntegerColumn("Likes", 0),
            new DateTimeColumn("Date")
        );

        $schema->labelColumnName = "CommentID";

        return $schema;
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord()) {
            $this->Date = new RhubarbDateTime("now");
        }
        parent::beforeSave();
    }

    public static function getCommentsForPage($urlPath)
    {
        return Comment::find(
            new AndGroup([
                new Equals("UrlPath", $urlPath),
                new Equals("ParentCommentID", 0)
            ])
        );
    }

    public static function getRepliesForComment($commentID)
    {
        return Comment::find(new Equals("ParentCommentID", $commentID));
    }

    public static function likeComment($commentID)
    {
        $comment = new Comment($commentID);
        $comment->Likes = $comment->Likes + 1;
        $comment->save(true);
    }
}