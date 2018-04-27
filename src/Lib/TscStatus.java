import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.InetSocketAddress;
import java.net.Socket;

/**
 *
 * @author jc
 */
public class TscStatus {

	private InputStream inStream = null;
    private OutputStream outStream = null;
    private Socket socket = null;

    private boolean port_connected = false;

    public TscStatus() {}

    public boolean openport(String ipaddress, int portnumber) {
        try {
            this.socket = new Socket();
            this.socket.connect(new InetSocketAddress(ipaddress, portnumber), 2000);

            this.inStream = this.socket.getInputStream();
            this.outStream = this.socket.getOutputStream();
            
            this.port_connected = true;
        } catch (IOException ex) {
            this.port_connected = false;
        }
        return this.port_connected;
    }

    public String status() {
        if (!this.port_connected) {
            return "-1";
        }

        byte[] message = {27, 33, 63}; // Status Polling and Immediate Commands

        try {
            outStream.write(message);
        } catch (IOException e) {
            return "";
        }

        try {
            Thread.sleep(100);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        byte[] readBuf = new byte['Ѐ'];
        try {
            while (inStream.available() > 0) {
                readBuf = new byte['Ѐ'];
                inStream.read(readBuf);
            }
        } catch (IOException e) {
            return "";
        }

        String query = "";
        if (readBuf[0] == 0) {
            query = "Normal"; // 0
        } else if (readBuf[0] == 1) {
            query = "Tapa Abierta"; // 1
        } else if (readBuf[0] == 2) {
            query = "Papel Atascado"; // 2
        } else if (readBuf[0] == 3) {
            query = "Papel Atascado y Tapa Abierta"; // 3
        } else if (readBuf[0] == 4) {
            query = "Sin Papel"; // 4
        } else if (readBuf[0] == 5) {
            query = "Sin Papel y Tapa Abierta"; // 5
        } else if (readBuf[0] == 8) {
            query = "Sin Cinta"; // 8
        } else if (readBuf[0] == 9) {
            query = "Sin Cinta y Tapa Abierta"; // 9
        } else if (readBuf[0] == 10) {
            query = "Sin Cinta y Papel Atascado"; // A
        } else if (readBuf[0] == 11) {
            query = "Sin Cinta, Papel Atascado y Tapa Abierta"; // B
        } else if (readBuf[0] == 12) {
            query = "Sin Cinta y Sin Papel"; // C
        } else if (readBuf[0] == 13) {
            query = "Sin Cinta, Sin Papel y Tapa Abierta"; // D
        } else if (readBuf[0] == 16) {
            query = "Pausado"; // 10
        } else if (readBuf[0] == 14) {
            query = "Imprimiendo"; // 20
        } else if (readBuf[0] == 128) {
            query = "Error Desconocido"; // 80
        }

        return query;
    }

    public String closeport() {
        /*try {
            Thread.sleep(1500L);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }*/

        if (!port_connected) {
            return "-1";
        }
        try {
            socket.close();
        } catch (IOException e) {
            return "-1";
        }

        return "1";
    }

    public static void main(String[] args) {
        if(args.length == 0){
            System.out.println("Ejemplo de uso:");
            System.out.println("java TscStatus <IP> [<PORT>|9100]");
            return;
        }

        String ip = "";
        int port = 9100;

        if(args.length > 0){
            ip = args[0];
        }

        if(args.length > 1){
            port = Integer.parseInt(args[1]);
        }

        TscStatus tscStatus = new TscStatus();
    	boolean res = tscStatus.openport(ip, port);
        if(res){
            //System.out.println(System.currentTimeMillis());
            String status = tscStatus.status();
            System.out.println(status);
            //System.out.println(System.currentTimeMillis());
            tscStatus.closeport();
        }else{
            System.out.println("Error al conectar a la impresora");
        }
    }
    
}