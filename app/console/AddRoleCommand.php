<?php

namespace App\Command;

use App\Model\Role;
use App\Model\RoleFacade;
use Doctrine;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddRoleCommand extends Command {

    /** @var RoleFacade */
    private $roleFacade;

    /**
     * AddDefaultRolesCommand constructor.
     *
     * @param RoleFacade $roleFacade
     */
    public function __construct(RoleFacade $roleFacade) {
        parent::__construct();
        $this->roleFacade = $roleFacade;
    }

    protected function configure() {
        $this
            ->setName('app:add-role')
            ->setDescription('Add role')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'Name')
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        try {

            $name = $input->getArgument('name');

            $role = new Role($name);
            $this->roleFacade->save($role);

            $output->writeln("Role with name: `$name` has been added.");

            return 0;
        } catch (UniqueConstraintViolationException $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);

            $output->writeln($exception->getMessage());

            return 1;
        } catch(\Exception $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);
            $output->writeln("Failed.");

            return 1;
        }
    }

}
