<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 10/11/17
 * Time: 20:44
 */

namespace AppBundle\Command;

use AppBundle\Handler\ProjectHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadProjectCommand extends ContainerAwareCommand
{
    private $projectHandler;

    public function __construct(ProjectHandler $projectHandler, $name = null)
    {
        $this->projectHandler = $projectHandler;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:load-project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->projectHandler->save();

        $output->writeln('Project successfully loaded!');
    }
}