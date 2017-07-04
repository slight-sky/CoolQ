<?php

/**
 * Created by PhpStorm.
 * User: Slight
 * Date: 2017/5/5 0005
 * Time: 13:56
 */

namespace  CoolQ\Db;

class MySql
{

    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbTable;
    private $dbPort;
    private $link;
    private $result;
    private static $instance = null;

    /**
     * 初始化数据链接数据库
     *
     * * @param string $dbHost
     * * @param string $dbUser
     * * @param string $dbPassword
     * * @param string $dbTable
     * * @param string $dbPort
     */
    private function __construct($dbHost, $dbUser, $dbPassword, $dbTable, $dbPort)
    {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbTable = $dbTable;
        $this->dbPort = $dbPort;
        self::connect($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbTable, $this->dbPort);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance($config = array())
    {
        // 检查对象是否已经存在，不存在则实例化后保存到$instance属性
        if (self::$instance == null) {
            self::$instance = new self($config['dbHost'], $config['dbUser'], $config['dbPassword'], $config['dbTable'], $config['dbPort']);
        }
        return self::$instance;
    }


    /**
     * 接数据库
     *
     * @param string $dbHost
     * * @param string $dbUser
     * * @param string $dbPassword
     * * @param string $dbTable
     * * @param string $dbPort
     */
    private function connect($dbHost, $dbUser, $dbPassword, $dbTable, $dbPort)
    {
        $this->link = @mysqli_connect($dbHost, $dbUser, $dbPassword, $dbTable, $dbPort);
        if (mysqli_connect_errno()) {
            exit(mysqli_connect_error());
        }
        mysqli_set_charset($this->link, 'utf8');
        return $this->link;
    }

    /**
     * 插入一组数据或一条数据
     *
     * @param string $sql
     * @param   ""   $link
     */
    public function query($sql, $link = "")
    {
        if ($link == "") {

            $link = $this->link;

        }
        $result = mysqli_query($link, $sql);
        if (mysqli_errno($link)) {
            exit(mysqli_error($link));
        }

        return $result;
    }

    /**
     * 得到数据集中的一条信息
     *
     * @param 数据集 $result
     */
    public function getOne($result)
    {

        $result = mysqli_fetch_assoc($result);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * 得到数据集中的所有信息
     *
     * @param 数据集 $result
     */
    public function getAll($result)
    {
        $res = array();
        while ($r = self::getOne($result)) {
            $res[] = $r;
        }
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }


}











