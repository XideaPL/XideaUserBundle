<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\Model\Loader;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
interface UserLoaderInterface
{
    /**
     * Returns a user by id.
     * 
     * @param int $id
     * 
     * @return Xidea\Bundle\UserBundle\Model\UserInterface
     */
    function load($id);
    
    /**
     * Returns all categories.
     * 
     * @return array
     */
    function loadAll();
    
    /**
     * Returns a set of categories matching the criteria.
     * 
     * @return array
     */
    function loadBy(array $criteria, array $orderBy = array(), $limit = null, $offset = null);
}
