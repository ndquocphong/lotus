<?php
declare(strict_types=1);
namespace Lotus\Core\Domain\Model;

use Lotus\Core\Application;

class Module
{
    const STATUS_INSTALLED = 0;

    const STATUS_ENABLED = 1;

    const STATUS_DISABLED = 2;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var int
     */
    protected $status;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Boot module
     *
     * @param Application $application
     */
    public function boot(Application $application): void
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $this->getPath());
        $namespace = str_replace('/', '\\', $this->getPath());
        $application->getAutoloader()->addPsr4(
            $namespace . '\\',
            [
                MODULE_DIR . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . 'src',
                MODULE_DIR . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'code',
            ]
        );
    }
}
