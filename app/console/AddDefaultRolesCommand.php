<?php

namespace App\Command;

use App\Model\Role;
use App\Model\RoleFacade;
use Doctrine;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddDefaultRolesCommand extends Command {

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
        $this->setName('app:add:roles')->setDescription('Adds default roles');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        try {

            $roleAdmin = new Role(Role::ADMIN);
            $this->roleFacade->save($roleAdmin);

            $roleUser = new Role(Role::USER);
            $this->roleFacade->save($roleUser);

            $output->writeln("Default roles `admin` and `user` has been successfully added.");

            return 0;
        } catch (UniqueConstraintViolationException $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);

            $output->writeln("Default roles `admin` and `user` have been already added.");

            return 1;
        } catch(\Exception $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);
            $output->writeln("Failed.");

            return 1;
        }
    }

}
