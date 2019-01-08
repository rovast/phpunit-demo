# phpunit-demo

phpunit 文档导读 && 示例

[TOC]

## 安装 phpunit

### 项目安装
```bash
composer require --dev phpunit/phpunit
```
使用 `./vendor/bin/phpunit`

### 全局安装
```bash
composer global require --dev phpunit/phpunit
```
使用 `phpunit`

## 快速入门

### 基本格式

- 测试类命名： `类名 + Test` ， eg `FooClassTest`
- 测试方法命名： `test + 方法名`, eg `testFoo`

> 也可以使用注释 `@test` 来标注需要测试的方法

```php
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    public function testSomething()
    {
        $this->assertTrue(true, 'This should already work.');
    }
    
    /**
     * @test
     */
    public function something()
    {
        $this->assertTrue(true, 'This should already work.');
    }
}
```

### 测试依赖(@depends)

有一些测试方法需要依赖于另一个测试方法的返回值，此时需要使用测试依赖。测试依赖
通过注释 `@depends` 来标记。

下列中， depends 方法的 return 值作为 testConsumer 的参数传入

```php
use PHPUnit\Framework\TestCase;

class MultipleDependenciesTest extends TestCase
{
    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    public function testConsumer($a, $b)
    {
        $this->assertSame('first', $a);
        $this->assertSame('second', $b);
    }
}
```

### 数据提供器(@dataProvider)

在依赖中，所依赖函数的返回值作为参数传入测试函数。除此之外，我们也可以用数据提供器
来定义传入的数据。

```php
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAdd($a, $b, $expected)
    {
        $this->assertSame($expected, $a + $b);
    }

    public function additionProvider()
    {
        return [
            'adding zeros' => [0, 0, 0], // 0 + 0 = 0 pass
            'zero plus one' => [0, 1, 1], // 0 + 1 = 1 pass
            'one plus zero' => [1, 0, 1], // 1 + 0 = 1 pass
            'one plus one' => [1, 1, 2], // 1 + 1 = 2 pass
        ];
    }
}
```

### 测试异常(expectException)

需要在测试方法的开始处声明断言，然后执行语句。**而不是调用后再声明**

也可以通过注释来声明 `@expectedException`, `@expectedExceptionCode`, 
`@expectedExceptionMessage`, `@expectedExceptionMessageRegExp`

```php
use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException(\Exception::class);

        throw new \Exception('test');
    }

    /**
     * @throws \Exception
     * @test
     * @expectedException \Exception
     */
    public function exceptionExpect()
    {
        throw new \Exception('test');
    }
}
```

### 测试 PHP 错误

通过提前添加期望，来使测试正常进行，而不会报出 PHP 错误

```php
use PHPUnit\Framework\TestCase;

class ExpectedErrorTest extends TestCase
{
    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }
}
```

### 测试输出

直接添加期望输出，然后执行相关函数。和测试异常类似，需要先添加期望，再执行代码。

```php
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    public function testExpectFooActualFoo()
    {
        $this->expectOutputString('foo');
        print 'foo';
    }

    public function testExpectBarActualBaz()
    {
        $this->expectOutputString('bar');
        print 'baz';
    }
}
```

## 命令行测试

此章节主要说明了命令行的一些格式和可用参数。可以参考官方文档
获取细节。[The Command-Line Test Runner](https://phpunit.readthedocs.io/en/7.4/textui.html)

## 基境

基境就是在测试前需要准备的一系列东西。

比如有的测试需要依赖数据库的数据，那么在测试类运作前需要进行数据的准备。

主要有两个函数 `setUp` 和 `tearDown`。
> 那为什么不直接用构造函数和析构函数呢？是因为这两个有他用，当然你可可以直接用构造函数，然后
再执行 `parent::__construct`，但不是麻烦嘛;

## 组织你的测试代码

可以通过命令行的 `--bootstrap` 参数来指定启动文件，用于文件加载。正常情况下，可以指向 composer 的 autoload 文件。
也可以在配置文件中配置（推荐）。

```bash
$ phpunit --bootstrap src/autoload.php tests
PHPUnit |version|.0 by Sebastian Bergmann and contributors.

.................................

Time: 636 ms, Memory: 3.50Mb

OK (33 tests, 52 assertions)
```

```xml
<phpunit bootstrap="src/autoload.php">
  <testsuites>
    <testsuite name="money">
      <directory>tests</directory>
    </testsuite>
  </testsuites>
</phpunit>
```

## 有风险的测试(Risky Tests)

### 无用测试(Useless Tests)

默认情况下，如果你的测试函数没有添加预期或者断言，就会被认为是无用测试。

> 通过设置 `--dont-report-useless-tests` 命令行参数，或者在 xml 配置
文件中配置 `beStrictAboutTestsThatDoNotTestAnything="false"` 来更改
这一默认行为。

### 意外的代码覆盖(Unintentionally Covered Code)

当打开这个配置后，如果使用 `@covers` 注释来包含一些文件的覆盖报告，就会被
判定为有风险的测试。

> 通过设置 `--strict-coverage` 命令行参数，或者在 xml 配置
文件中配置 `beStrictAboutCoversAnnotation="true"` 来更改
这一默认行为。

### 测试过程中有输出(Output During Test Execution)

如果在测试过程中输出文本，则会被认定为有风险的测试。

> 通过设置 `--disallow-test-output` 命令行参数，或者在 xml 配置
文件中配置 `beStrictAboutOutputDuringTests="true"` 来更改
这一默认行为。

### 测试超时(Test Execution Timeout)

通过注释来限制某些测试不能超过一定时间：
- @large 60秒
- @medium 10秒
- @small 1秒


> 通过设置 `--enforce-time-limit` 命令行参数，或者在 xml 配置
文件中配置 `enforceTimeLimit="true"` 来更改
这一默认行为。

### 操作全局状态(Global State Manipulation)

phpunit 可以对全局状态进行检测。

> 通过设置 `--strict-global-state` 命令行参数，或者在 xml 配置
文件中配置 `beStrictAboutChangesToGlobalState="true"` 来更改
这一默认行为。
