<?php
namespace Example\BlogApp\TableGateways\Base;
use \⌬\Controllers\Abstracts\TableGateway as AbstractTableGateway;
use \⌬\Controllers\Abstracts\Model;
use \⌬\Database\Db;
use \Example\BlogApp\TableGateways;
use \Example\BlogApp\Models;
use \Laminas\Db\Adapter\AdapterInterface;
use \Laminas\Db\ResultSet\ResultSet;
use \Gone\AppCore\Exceptions;

/********************************************************
 *             ___                         __           *
 *            / _ \___ ____  ___ ____ ____/ /           *
 *           / // / _ `/ _ \/ _ `/ -_) __/_/            *
 *          /____/\_,_/_//_/\_, /\__/_/ (_)             *
 *                         /___/                        *
 *                                                      *
 * Anything in this file is prone to being overwritten! *
 *                                                      *
 * This file was programatically generated. To modify   *
 * this classes behaviours, do so in the class that     *
 * extends this, or modify the Laminator Template!     *
 ********************************************************/
// @todo: Make all TableGateways implement a TableGatewayInterface. -MB
abstract class BaseCommentsTableGateway extends AbstractTableGateway
{
    protected $table = 'comments';

    protected $database = 'mysql';

    protected $model = Models\CommentsModel::class;

    /** @var \Faker\Generator */
    protected $faker;

    /** @var Db */
    private $databaseConnector;

    private $databaseAdaptor;

    /** @var TableGateways\UsersTableGateway */
    protected $usersTableGateway;

    /**
     * AbstractTableGateway constructor.
     *
     * @param TableGateways\UsersTableGateway $usersTableGateway,
     * @param Db $databaseConnector
     *
     * @throws Exceptions\DbException
     */
    public function __construct(
                TableGateways\UsersTableGateway $usersTableGateway,
                \Faker\Generator $faker,
        Db $databaseConnector
    )
    {
        $this->usersTableGateway = $usersTableGateway;
        $this->faker = $faker;
        $this->databaseConnector = $databaseConnector;

        /** @var $adaptor AdapterInterface */
        // @todo rename all uses of 'adaptor' to 'adapter'. I cannot spell - MB
        $this->databaseAdaptor = $this->databaseConnector->getDatabase($this->database);
        $resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new $this->model);
        return parent::__construct($this->table, $this->databaseAdaptor, null, $resultSetPrototype);
    }

    /**
     * @return Models\CommentsModel
     */
    public function getNewMockModelInstance()
    {
      // Generate a Random Users.
      $randomUsers = $this->usersTableGateway->fetchRandom();

      $newCommentsData = [
        // authorId. Type = int. PHPType = int. Has related objects.
        'authorId' =>
            $randomUsers instanceof Models\UsersModel
                ? $this->usersTableGateway->fetchRandom()->getId()
                : $this->usersTableGateway->getNewMockModelInstance()->save()->getId(),

        // comment. Type = text. PHPType = string. Has no related objects.
        'comment' => substr($this->faker->text(500 >= 5 ? 500 : 5), 0, 500),
        // id. Type = int. PHPType = int. Has no related objects.
        // publishedDate. Type = datetime. PHPType = string. Has no related objects.
        'publishedDate' => $this->faker->dateTime()->format("Y-m-d H:i:s"), // @todo: Make datetime fields accept DateTime objects instead of strings. - MB
      ];
      $newComments = $this->getNewModelInstance($newCommentsData);
      return $newComments;
    }

    /**
     * @param array $data
     * @return Models\CommentsModel
     */
    public function getNewModelInstance(array $data = [])
    {
        return parent::getNewModelInstance($data);
    }

    /**
     * @param Models\CommentsModel $model
     * @return Models\CommentsModel
     */
    public function save(Model $model)
    {
        return parent::save($model);
    }
}