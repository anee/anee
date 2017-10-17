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
        $this->setName('app:add-roles')->setDescription('Adds default roles');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        try {

            $roleAdmin = new Role(Role::ADMIN);
            $admin = $this->roleFacade->save($roleAdmin);
            $adminId = $admin->getId();

            $output->writeln("Role with name: `admin` and id: `$adminId` has been successfully added.");

            $roleUser = new Role(Role::USER);
            $user = $this->roleFacade->save($roleUser);
            $userId = $user->getId();

            $output->writeln("Role with name: `admin` and id: `$userId` has been successfully added.");

            return 0;
        } catch (UniqueConstraintViolationException $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);

            $output->writeln("Default roles with name: `admin` and `user` have been already added.");

            return 1;
        } catch(\Exception $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);
            $output->writeln("Failed.");

            return 1;
        }
    }

}
