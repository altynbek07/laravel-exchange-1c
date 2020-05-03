<?php

namespace Altynbek07\Exchange1C\Interfaces;

interface GroupInterface extends IdentifierInterface
{
    /**
     * Создание дерева групп
     * в параметр передаётся массив всех групп (import.xml > Классификатор > Группы)
     * $groups[0]->parent - родительская группа
     * $groups[0]->children - дочерние группы.
     *
     * @param \Zenwalker\CommerceML\Model\Group[] $groups
     *
     * @return void
     */
    public static function createTree1c($groups);
}
