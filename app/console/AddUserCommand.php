<?php

namespace App\Command;

use App\Model\User;
use App\Model\UserFacade;
use Doctrine;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class AddUserCommand extends Command
{

    /** @var UserFacade */
    private $userFacade;

    /**
     * AddUserCommand constructor.
     *
     * @param UserFacade $userFacade
     */
    public function __construct(UserFacade $userFacade)
    {
        parent::__construct();
        $this->userFacade = $userFacade;
    }

    protected function configure()
    {
        $this->setName('app:add-user')
            ->setDescription('Add user')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'Username'),
                new InputArgument('forename', InputArgument::REQUIRED, 'Forename'),
                new InputArgument('surname', InputArgument::REQUIRED, 'Surname'),
                new InputArgument('email', InputArgument::REQUIRED, 'Email'),
                new InputArgument('password', InputArgument::REQUIRED, 'Password'),
                new InputOption('public', 'p', InputOption::VALUE_REQUIRED, 'Public profile', false),
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $forename = $input->getArgument('forename');
        $surname = $input->getArgument('surname');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $public = $input->getOption('public');

        $user = new User($username, $forename, $surname, $public, $email, $password);

        try {
            $this->userFacade->save($user);

            $name = $user->getName();
            $output->writeln("User with name: `$name`, username: `$username` and email: `$email` has been added.");

            return 0;
        } catch (UniqueConstraintViolationException $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);

            $output->writeln($exception->getMessage());

            return 1;
        } catch (\Exception $exception) {
            Debugger::log($exception, ILogger::EXCEPTION);
            $output->writeln("Failed.");

            return 1;
        }
    }

}
