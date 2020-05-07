<?php

namespace Altynbek07\Exchange1C\Services;

use Altynbek07\Exchange1C\Config;
use Altynbek07\Exchange1C\Events\AfterProductsSync;
use Altynbek07\Exchange1C\Events\AfterUpdateProduct;
use Altynbek07\Exchange1C\Events\BeforeProductsSync;
use Altynbek07\Exchange1C\Events\BeforeUpdateProduct;
use Altynbek07\Exchange1C\Exceptions\Exchange1CException;
use Altynbek07\Exchange1C\Interfaces\EventDispatcherInterface;
use Altynbek07\Exchange1C\Interfaces\GroupInterface;
use Altynbek07\Exchange1C\Interfaces\ModelBuilderInterface;
use Altynbek07\Exchange1C\Interfaces\ProductInterface;
use Symfony\Component\HttpFoundation\Request;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Product;

/**
 * Class SectionsService.
 */
class CategoryService
{
    /**
     * @var array Массив идентификаторов товаров которые были добавлены и обновлены
     */
    protected $_ids;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var ModelBuilderInterface
     */
    private $modelBuilder;

    /**
     * CategoryService constructor.
     *
     * @param Request                  $request
     * @param Config                   $config
     * @param EventDispatcherInterface $dispatcher
     * @param ModelBuilderInterface    $modelBuilder
     */
    public function __construct(Request $request, Config $config, EventDispatcherInterface $dispatcher, ModelBuilderInterface $modelBuilder)
    {
        $this->request = $request;
        $this->config = $config;
        $this->dispatcher = $dispatcher;
        $this->modelBuilder = $modelBuilder;
    }

    /**
     * Базовый метод запуска импорта.
     *
     * @throws Exchange1CException
     */
    public function import(): void
    {
        $this->_ids = [];
        $filename = basename($this->request->get('filename'));
        $commerce = new CommerceML();
        $commerce->loadImportXml($this->config->getFullPath($filename));
        $classifierFile = $this->config->getFullPath('classifier.xml');
        if ($commerce->classifier->xml) {
            $commerce->classifier->xml->saveXML($classifierFile);
        } else {
            $commerce->classifier->xml = simplexml_load_string(file_get_contents($classifierFile));
        }
        $this->beforeProductsSync();

        if ($groupClass = $this->getGroupClass()) {
            $groupClass::createTree1c($commerce->classifier->getGroups());
        }

        $productClass = $this->getProductClass();
        $productClass::createProperties1c($commerce->classifier->getProperties());
        foreach ($commerce->catalog->getProducts() as $product) {
            if (!$model = $productClass::createModel1c($product)) {
                \Log::error("Модель продукта не найдена, проверьте реализацию $productClass::createModel1c");
                continue;
            }
            $this->parseProduct($model, $product);
            $this->_ids[] = $model->getPrimaryKey();
            $model = null;
            unset($model, $product);
            gc_collect_cycles();
        }
        $this->afterProductsSync();
    }

    /**
     * @return GroupInterface|null
     */
    protected function getGroupClass(): ?GroupInterface
    {
        return $this->modelBuilder->getInterfaceClass($this->config, GroupInterface::class);
    }

    /**
     * @return ProductInterface|null
     */
    protected function getProductClass(): ?ProductInterface
    {
        return $this->modelBuilder->getInterfaceClass($this->config, ProductInterface::class);
    }

    /**
     * @param ProductInterface                    $model
     * @param \Zenwalker\CommerceML\Model\Product $product
     */
    protected function parseProduct(ProductInterface $model, Product $product): void
    {
        $this->beforeUpdateProduct($model);
        $model->setRaw1cData($product->owner, $product);
        $this->parseGroups($model, $product);
        $this->parseProperties($model, $product);
        $this->parseRequisites($model, $product);
        $this->parseImage($model, $product);
        $this->afterUpdateProduct($model);

        unset($group);
    }

    /**
     * @param ProductInterface $model
     * @param Product          $product
     */
    protected function parseGroups(ProductInterface $model, Product $product): void
    {
        $group = $product->getGroup();
        $model->setGroup1c($group);
    }

    /**
     * @param ProductInterface $model
     * @param Product          $product
     */
    protected function parseProperties(ProductInterface $model, Product $product): void
    {
        foreach ($product->getProperties() as $property) {
            $model->setProperty1c($property);
        }
    }

    /**
     * @param ProductInterface $model
     * @param Product          $product
     */
    protected function parseRequisites(ProductInterface $model, Product $product): void
    {
        $requisites = $product->getRequisites();
        foreach ($requisites as $requisite) {
            $model->setRequisite1c($requisite->name, $requisite->value);
        }
    }

    /**
     * @param ProductInterface $model
     * @param Product          $product
     */
    protected function parseImage(ProductInterface $model, Product $product)
    {
        $images = $product->getImages();
        foreach ($images as $image) {
            $path = $this->config->getFullPath(basename($image->path));
            if (file_exists($path)) {
                $model->addImage1c($path, $image->caption);
            }
        }
    }

    protected function beforeProductsSync(): void
    {
        $event = new BeforeProductsSync();
        $this->dispatcher->dispatch($event);
    }

    protected function afterProductsSync(): void
    {
        $event = new AfterProductsSync($this->_ids);
        $this->dispatcher->dispatch($event);
    }

    /**
     * @param ProductInterface $model
     */
    protected function beforeUpdateProduct(ProductInterface $model): void
    {
        $event = new BeforeUpdateProduct($model);
        $this->dispatcher->dispatch($event);
    }

    /**
     * @param ProductInterface $model
     */
    protected function afterUpdateProduct(ProductInterface $model): void
    {
        $event = new AfterUpdateProduct($model);
        $this->dispatcher->dispatch($event);
    }
}
